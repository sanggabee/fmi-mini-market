<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Mini-Market',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.validators.*',
        'application.extensions.StateMachine.*',
		'application.states.*',
		'application.db.*',
		'application.widgets.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		//*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		//*/
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
            'class'=>'WebUser',
			'allowAutoLogin'=>true,
		),
//		'urlManager'=>array(
//			'urlFormat'=>'path',
//			'rules'=>array(
//				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
//				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
//			),
//		),
		
		'db'=> require (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.db.php'),
		'errorHandler'=>array(
            'errorAction'=>'site/error',
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
	'params'=>array(
		'adminEmail'=>'ndobromirov@gmail.com',
        'userSalt' => 'asdj(&^YOjsfhipawfliuhLIUYlgf92felHOg',
        'uploadsDirectory' => 'uploads',
        'dbDateFormat'=>'Y-m-d H:i:s',
        'currency' => 'лв.',
        'author' => 'Nikolay Dobormirov',
	),
);