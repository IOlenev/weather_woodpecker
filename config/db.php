<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=wwp_db;dbname=wwp',
    'username' => 'root',
    'password' => 'rootpwd',
    'charset' => 'utf8',
    'on afterOpen' => function($event) {
        $event->sender->createCommand("SET sql_mode = ''")->execute();
    }

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
