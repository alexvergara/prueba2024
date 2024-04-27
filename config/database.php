<?php

/*
|--------------------------------------------------------------------------
| Database Configuration
|--------------------------------------------------------------------------
|
| Here you can define your database configuration. You can use the
| `uri` key to define the connection URI, or use the `host`, `port`,
| `dbname`, and `charset` keys to define the individual connection
| parameters.
|
*/

return [
    'uri' => [
        'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'port' => getenv('DB_PORT') ?: '3306',
        'dbname' => getenv('DB_DATABASE'),
        'charset' => getenv('DB_CHARSET') ?: 'utf8mb4',
    ],
    'username' => getenv('DB_USERNAME') ?: 'root',
    'password' => getenv('DB_PASSWORD') ?: '',
];
