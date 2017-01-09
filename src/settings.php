<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // DB settings
        'db' => [
          'type'    => 'sqlite',
          'path'    => __DIR__ . '/../../wikka',
          'prefix'  => 'wikka_',
          'host'    => "localhost",
          'user'    => "wikka",
          'pass'    => "wikka-password",
          'dbname'  => "wikka",
        ],
    ],
];

/*
'type'    => 'mysql',
'path'    => __DIR__ . '/../../wikka',
'host'    => "localhost",
'user'    => "wikka",
'pass'    => "wikka-password",
'dbname'  => "wikka",
*/

/*
'type'    => 'sqlite',
'path'    => __DIR__ . '/../../wikka',
'host'    => "localhost",
'user'    => "user",
'pass'    => "password",
'dbname'  => "exampleapp",
*/
