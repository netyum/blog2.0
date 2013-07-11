<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'id' => 'blog',
	'name'=>'Yii2.0 Public Preview Blog Demo',

	'defaultRoute'=>'post',
	'preload'=>array('log'),
	
	// application components
	'components'=>array(
		'cache' => array(
			'class' => 'yii\caching\FileCache',
		),
		'user' => array(
			'class' => 'yii\web\User',
			'identityClass' => 'app\components\UserIdentity',
		),
		'assetManager' => array(
 			'bundles' => require(__DIR__ . '/assets.php'),
 		),
		'urlManager'=>array(
			'class'=>'yii\web\UrlManager',
			'enablePrettyUrl'=>true,
			'rules'=>array(
				'post/<id:\d+>/<title:.*?>'=>'post/view',
				'posts/<tag:.*?>'=>'post/index',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),  
		),
		'errorHandler'=>array(
			'class' => 'yii\base\ErrorHandler',
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'db' => array(
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=localhost;dbname=blog',
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'tablePrefix'=>'tbl_',
			'enableSchemaCache'=> !YII_DEBUG,
		),
		'log'=>array(
			'targets'=>array(
				'file' => array(
					'class'=>'yii\log\FileTarget',
 					'levels'=> array('trace', 'error', 'warning'),
					'categories' => array('yii\db\*'),
				),  
				// uncomment the following to show log messages on web pages
				/*'web' => array(
					'class'=>'yii\logging\WebTarget',
				),*/
			),  
 		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);
