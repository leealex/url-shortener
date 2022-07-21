<?php

$params = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];

if (file_exists(__DIR__ . '/db.local.php')) {
    $params = array_merge($params, require __DIR__ . '/db.local.php');
}

return $params;