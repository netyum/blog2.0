<?php
// comment out the following line to disable debug mode
defined('YII_DEBUG') or define('YII_DEBUG', true);

$frameworkPath = 'yii2/framework/yii';

require($frameworkPath . '/Yii.php');
// Register Composer autoloader
@include($frameworkPath . '/vendor/autoload.php');

$config = require dirname(__DIR__).'/app/config/main.php';
$config['basePath'] = dirname(__DIR__).'/app';

$app = new \yii\web\Application($config);
$app->run();
