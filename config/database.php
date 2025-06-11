<?php

use Illuminate\Support\Str;

require(__DIR__ . '/../../include/connect.php');

return [

    'default' => 'mysql',

    'connections' => [

        'mysql' => [
            'driver' => 'mysql',
            'host' => $HOST,
            'port' => '3306',
            'database' => $DB,
            'username' => $USER,
            'password' => $PASSWORD,
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => null,
            ]) : [],
        ],
    ],

    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => true,
    ],

    'redis' => [

        'client' => 'phpredis',

        'options' => [
            'cluster' => 'redis',
            'prefix' => Str::slug('laravel', '_') . '_database_',
            'persistent' => false,
        ],

        'default' => [
            'host' => '127.0.0.1',
            'port' => '6379',
            'database' => '0',
        ],

        'cache' => [
            'host' => '127.0.0.1',
            'port' => '6379',
            'database' => '1',
        ],
    ],
];
