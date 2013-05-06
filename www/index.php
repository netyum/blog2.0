<?php
define('YII_DEBUG', true);
require __DIR__.'/../../../../yii2/framework/yii.php';
$config = require dirname(__DIR__).'/app/config/main.php';
$config['basePath'] = dirname(__DIR__).'/app';

$app = new \yii\web\Application($config);
$app->run();
