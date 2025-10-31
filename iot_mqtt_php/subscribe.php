<?php
// Dependencies and configuration
require __DIR__ . '/vendor/autoload.php';

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

// Load configuration from config.php
$config = require __DIR__ . '/config.php';

// Database connection string
$connStr = sprintf(
    "host=%s port=%s dbname=%s user=%s password=%s",
    $config['pg_host'], $config['pg_port'], $config['pg_db'],
    $config['pg_user'], $config['pg_pass']
);

// Connect to PostgreSQL database
$db = pg_connect($connStr);
if (!$db) {
    fwrite(STDERR, "❌ PostgreSQL connection failed\n");
    exit(1);
}

$check = pg_query($db, "SELECT name FROM pg_prepared_statements WHERE name = 'insert_reading'");
if (pg_num_rows($check) === 0) {
    pg_prepare($db, "insert_reading",
        "INSERT INTO {$config['pg_table']} (humidity, temperature) VALUES ($1, $2)"
    );
    echo "🔧 Prepared statement 'insert_reading' created\n";
} else {
    echo "🔍 Using existing 'insert_reading' statement\n";
}

// Configure MQTT client
$mqtt = new MqttClient($config['mqtt_host'], $config['mqtt_port'], $config['mqtt_client_id']);
$settings = (new ConnectionSettings())
    ->setUsername($config['mqtt_username'])
    ->setPassword($config['mqtt_password'])
    ->setKeepAliveInterval(60)
    ->setUseTls(false);

try {
    $mqtt->connect($settings, true);
    echo "✅ Connected to MQTT {$config['mqtt_host']}:{$config['mqtt_port']}\n";
} catch (Throwable $e) {
    fwrite(STDERR, "❌ MQTT connection error: {$e->getMessage()}\n");
    pg_close($db);
    exit(1);
}

// Handle incoming MQTT messages
$onMessage = function (string $topic, string $message, bool $retained) use ($db, $config) {
    echo "📥 [$topic] $message" . ($retained ? " (retained)" : "") . "\n";

    $data = json_decode($message, true);
    if (!is_array($data) || !isset($data['humidity'], $data['temperature'])) {
        echo "⚠️ Invalid format. Expected: {\"humidity\":.., \"temperature\":..}\n";
        return;
    }

    $humidity = floatval($data['humidity']);
    $temperature = floatval($data['temperature']);

    if ($humidity < 0 || $humidity > 100 || $temperature < -50 || $temperature > 100) {
        echo "⚠️ Values out of range. Skipping.\n";
        return;
    }

    $result = pg_execute($db, "insert_reading", [$humidity, $temperature]);
    if ($result) {
        echo "💾 Saved to DB: H={$humidity}% T={$temperature}°C\n";
    } else {
        echo "❌ DB error: " . pg_last_error($db) . "\n";
    }

    if (!empty($config['thingspeak']['url']) && !empty($config['thingspeak']['api_key'])) {
        $url = $config['thingspeak']['url']
             . '?api_key=' . $config['thingspeak']['api_key']
             . '&field1=' . $humidity
             . '&field2=' . $temperature;

        $response = @file_get_contents($url);

        if ($response !== false) {
            if ($response === '0') {
                echo "⚠️ ThingSpeak: RATE LIMIT (wait 15s)\n";
            } else {
                echo "📡 Sent to ThingSpeak: entry_id={$response}\n";
            }
        } else {
            echo "⚠️ Network error sending to ThingSpeak\n";
        }
    }
};

// Subscribe to MQTT topic with QoS level 1
$mqtt->subscribe($config['mqtt_topic'], function ($t, $m, $r) use ($onMessage) {
    $onMessage($t, $m, $r);
}, 1);

echo "👂 Listening to topic: {$config['mqtt_topic']} (Ctrl+C to exit)\n";

// Handle graceful shutdown on Ctrl+C
if (function_exists('pcntl_signal')) {
    pcntl_signal(SIGINT, function () use ($mqtt, $db) {
        echo "\n🔌 Closing connections...\n";
        $mqtt->disconnect();
        pg_close($db);
        exit(0);
    });
}

// Start MQTT loop (blocks execution)
$mqtt->loop(true);

// Cleanup on exit
$mqtt->disconnect();
pg_close($db);
?>
