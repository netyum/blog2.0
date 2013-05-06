<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'id' => 'blog',
	'name'=>'Yii Blog Demo',

	'defaultRoute'=>'post',

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
		'db' => array(
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=localhost;dbname=blog',
			'username' => 'root',
			'password' => '',
			'tablePrefix'=>'tbl_'
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);
