<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'rubuy',
	'preload'=>array('log'),

	'import'=>array(
		'application.send_email.*',
        'application.models.*',
		'application.components.*',
		'application.stock.*',
		'application.extensions.*',
		'application.fundaction.*',
		'application.youku.*',
		'ext.helper.*',
		'application.proxy.*',
		'application.vendor.youzan-sdk.lib.*',
		'ext.redis.*',
	),

	'defaultController'=>'login',
	'components'=>array(
		'user'=>array(
			 'class' => 'WebUser',
			'loginUrl' => array('login/index'),
			'loginRequiredAjaxResponse' => '{"code": 401, "msg": "please login"}',
			'allowAutoLogin'=>true,
		),

		'db'=>array(
			'connectionString' => 'mysql:host=106.14.69.154;dbname=rubuy',
			'emulatePrepare' => true,
			'username' => 'ruby',
			'password' => 'YanDing-Web2017',
			'charset' => 'utf8',
		),

        "redis" => array(
            "class" => "ext.redis.ARedisConnection",
            "hostname" => "127.0.0.1",
            "port" => 6379,
            "database" => 0,
            "password" => '000000',
            "prefix" => "",
        ),

		'session' => array(
			'class' => 'system.web.CDbHttpSession',
			'connectionID' => 'db',
			'sessionTableName' => 'admin_session',
			'timeout' => 86400,
		),

		'curl' => array(
					'class' => 'ext.curl.Curl',
					'options' => array(
							CURLOPT_CONNECTTIMEOUT => 10,
							CURLOPT_TIMEOUT        => 10,
							CURLOPT_VERBOSE => false
					)
			),

		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),

		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'post/<id:\d+>/<title:.*?>'=>'post/view',
				'posts/<tag:.*?>'=>'post/index',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
	'params'=>require(dirname(__FILE__).'/params.php'),
);