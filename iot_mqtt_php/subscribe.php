<?php
    require __DIR__ . '/vendor/autoload.php';

    use PhpMqtt\Client\MqttClient;
    use PhpMqtt\Client\ConnectionSettings;

    $config = require __DIR__ . '/config.php';

    // Conexión PostgreSQL
    $connStr = sprintf(
    "host=%s port=%s dbname=%s user=%s password=%s",
    $config['pg_host'], $config['pg_port'], $config['pg_db'],
    $config['pg_user'], $config['pg_pass']
    );
    $db = pg_connect($connStr);
    if (!$db) { fwrite(STDERR, "❌ No se pudo conectar a PostgreSQL\n"); exit(1); }

    pg_prepare($db, "insert_lectura",
    "INSERT INTO data (humidity, temperature) VALUES ($1, $2)"
    );

    // Conexión MQTT
    $mqtt = new MqttClient($config['mqtt_host'], $config['mqtt_port'], $config['mqtt_client_id']);
    $settings = (new ConnectionSettings())
    ->setUsername($config['mqtt_username'])
    ->setPassword($config['mqtt_password'])
    ->setKeepAliveInterval(60)
    ->setUseTls(false);

    try {
    $mqtt->connect($settings, true);
    echo "✅ Conectado a MQTT {$config['mqtt_host']}:{$config['mqtt_port']}\n";
    } catch (Throwable $e) {
    fwrite(STDERR, "Error conectando a MQTT: {$e->getMessage()}\n");
    exit(1);
    }

    // Callback de recepción
    $onMessage = function (string $topic, string $message, bool $retained) use ($db) {
    echo "📥 [$topic] $message" . ($retained ? " (retained)" : "") . "\n";
    $data = json_decode($message, true);

    if (!is_array($data) || !isset($data['humidity'], $data['temperature'])) {
        echo "Formato inválido. Esperado: {\"humidity\":..,\"temperature\":..}\n";
        return;
    }
    $hum = floatval($data['humidity']);
    $tmp = floatval($data['temperature']);

    if ($hum < 0 || $hum > 100 || $tmp < -50 || $tmp > 100) {
        echo "⚠️ Valores fuera de rango. No insertado.\n"; return;
    }

    $ok = pg_execute($db, "insert_lectura", [$hum, $tmp]);
    echo $ok ? "💾 Insertado: H=$hum T=$tmp\n" : "❌ Error al insertar\n";
    };

    // Suscripción
    $mqtt->subscribe($config['mqtt_topic'], function ($t, $m, $r) use ($onMessage) {
    $onMessage($t, $m, $r);
    }, 1);

    echo "👂 Escuchando topic: {$config['mqtt_topic']} (Ctrl+C para salir)\n";
    $mqtt->loop(true);

    // Limpieza (si se rompe el loop)
    $mqtt->disconnect();
    pg_close($db);

?>