<?php

use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';
(new Dotenv())->bootEnv(__DIR__ . '/.env');

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => [
            'App\\Phinx\\Seeds' => 'db/seeds',
        ]
    ],
    'environments' => [
        'default_migration_table' => 'public.phinx',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'pgsql',
            'host' => 'localhost',
            'name' => 'production_db',
            'user' => 'root',
            'pass' => '',
            'port' => '5432',
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'pgsql',
            'host' => 'postgres',
            'name' => 'enduro',
            'user' => 'root',
            'pass' => 'root',
            'port' => '5432',
            'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => 'pgsql',
            'host' => 'localhost',
            'name' => 'enduro_preprod',
            'user' => 'postgres',
            'pass' => 'FH5D-BV8A-QIwZ-AaV3-42Sq',
            'port' => '5432',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
