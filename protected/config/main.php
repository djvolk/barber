<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Салон Валерия Аксенова',
        'defaultController'=>'main/index',
	'preload'=>array('log'),
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			'ipFilters'=>array('*','::1'),
		),

	),
    
	'components'=>array(
		'user'=>array(
                        'class' => 'WebUser',
			'allowAutoLogin'=>true,
                        'loginUrl'=>array('user/login'),
		),
                'authManager' => array(
                        'class' => 'PhpAuthManager',
                        'defaultRoles' => array('guest'),
                ),
                'smspilot' => array
                (
                      'class' => 'application.components.SmsPilot',
                ) ,           
		'urlManager'=>array(
                        'showScriptName' => false,
		),
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=sunlounger_barb',
			'emulatePrepare' => true,
			'username' => 'sunlounger_barb',
			'password' => '100691',
			'charset' => 'utf8',
		),
            
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'main/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);