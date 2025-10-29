<?php
// config.php
return [
    // MQTT
    'mqtt_host' => getenv('MQTT_HOST') ?: '127.0.0.1',
    'mqtt_port' => getenv('MQTT_PORT') ?: 1883,
    'mqtt_client_id' => getenv('MQTT_CLIENT_ID') ?: ('php-subscriber-' . getmypid()),
    'mqtt_username' => getenv('MQTT_USERNAME') ?: null,
    'mqtt_password' => getenv('MQTT_PASSWORD') ?: null,
    'mqtt_topic' => getenv('MQTT_TOPIC') ?: 'aula/sensores/ambiente',

    // Supabase / Postgres (DB_CONNECTION=pgsql)
    'pg_host'   => getenv('DB_HOST') ?: 'aws-1-us-east-1.pooler.supabase.com',
    'pg_port'   => getenv('DB_PORT') ?: '6543',
    'pg_db'     => getenv('DB_DATABASE') ?: 'postgres',
    'pg_user'   => getenv('DB_USERNAME') ?: 'postgres.hiccenogftyckfvlemdf',
    'pg_pass'   => getenv('DB_PASSWORD') ?: 'unicesmag',
    'pg_sslmode'=> getenv('DB_SSLMODE') ?: 'require',

    // Tabla donde insertar (ajusta si en tu proyecto es otro nombre)
    'pg_table'  => getenv('PG_TABLE') ?: 'data',
];