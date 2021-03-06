<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PDO Fetch Style
    |--------------------------------------------------------------------------
    |
    | By default, database results will be returned as instances of the PHP
    | stdClass object; however, you may desire to retrieve records in an
    | array format for simplicity. Here you can tweak the fetch style.
    |
    */

    'fetch' => PDO::FETCH_OBJ,

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'bd_laravel'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => 'InnoDB',
        ],

        'besa' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_SQL_HOST', 'localhost'),
            'database' => 'BESA',
            'username' => env('DB_SQL_USERNAME', 'forge'),
            'password' => env('DB_SQL_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
        ],

        'unoeereal' => [
          'driver' => 'sqlsrv',
          'host' => env('DB_SQL_HOST', 'localhost'),
          'database' => 'unoeereal',
          'username' => env('DB_SQL_USERNAME', 'forge'),
          'password' => env('DB_SQL_PASSWORD', ''),
          'charset' => 'utf8',
          'prefix' => '',
        ],

        'nominabesa' => [
           'driver' => 'sqlsrv',
           'host' => env('DB_SQL_NOMINA_HOST', 'localhost'),
           'database' => 'NominaACCIONBESA',
           'username' => env('DB_SQL_NOMINA_USERNAME', 'forge'),
           'password' => env('DB_SQL_NOMINA_PASSWORD', ''),
           'charset' => 'utf8',
           'prefix' => '',
        ],

        'qlikview' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_SQL_HOST', 'localhost'),
            'database' => 'Qlikview',
            'username' => env('DB_SQL_USERNAME', 'forge'),
            'password' => env('DB_SQL_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
        ],

        'aplicativos' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'database' => 'bd_aplicativos',
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_spanish2_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => 'InnoDB',
        ],

        'genericas' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'database' => 'bd_genericas',
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_spanish2_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => 'InnoDB',
        ],

        'desarrollo' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'database' => 'bd_desarrollo',
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_spanish2_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => 'InnoDB',
        ],


        'tiqueteshotel' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'database' => 'bd_tiqueteshotel',
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_spanish2_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => 'InnoDB',
        ],

        'intsce' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_SQL_WMS_HOST', '172.100.103.70'),
            'database' => env('DB_WMS_DATABASE', 'INTSCE'),
            'username' => env('DB_SQL_WMS_USERNAME', 'interface'),
            'password' => env('DB_SQL_WMS_PASSWORD', 'interface1'),
            'charset' => 'utf8',
            'prefix' => '',
        ],


        'scprd' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_SQL_WMS_HOST', '172.100.103.70'),
            'database' => env('DB_SCPRD_DATABASE', 'SCPRD'),
            'username' => env('DB_SQL_WMS_USERNAME', 'interface'),
            'password' => env('DB_SQL_WMS_PASSWORD', 'interface1'),
            'charset' => 'utf8',
            'prefix' => '',
        ],

        'conectoressiesa' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'database' => 'bd_conectores_siesa',
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_spanish2_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => 'InnoDB',
        ],



        'conectortccws' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'database' => 'bd_tccws',
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => 'InnoDB',
        ],


        'digitacionremesas' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'database' => 'bd_digitacionremesas',
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => 'InnoDB',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'cluster' => false,

        'default' => [
            'host' => env('REDIS_HOST', 'localhost'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];
