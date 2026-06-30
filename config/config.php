<?php

return array(
    'database'=> array(
        'type'     => getenv('DB_TYPE') ?: 'mysql',
        'host'     => getenv('DB_HOST') ?: 'localhost',
        'port'     => getenv('DB_PORT') ?: '3306',
        'user'     => getenv('DB_USER') ?: 'root',
        'pass'     => getenv('DB_PASS') ?: '',
        'charset'  => getenv('DB_CHARSET') ?: 'utf8mb4',
        'dbname'   => getenv('DB_NAME') ?: 'study',
        'prefix'   => getenv('DB_PREFIX') ?: 'S_',
        'fetch_mode' => PDO::FETCH_ASSOC,
    ),

    'drivers' => array(),

    'system' => array(
        'error_reporting' => E_ALL,
        'display_errors' => 1,
    ),
);