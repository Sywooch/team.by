<?php
//use developeruz\db_rbac\behaviors\AccessBehavior;
use pro\components\AUrlManager;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-pro',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'pro\controllers',
	'defaultRoute' => 'profile',
    'components' => [
        'session' => [
            'cookieParams' => ['domain' => '.team.by'],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
			'identityCookie' => [
				'name' => '_identity',
				'httpOnly' => true,
				'path' => '/',
				'domain' => '.team.by',
			],			
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
		
		'urlManager' => [
			//'class'=>'pro\components\AUrlManager',
			
			'enablePrettyUrl' => true,
			//'enableStrictParsing' => true,
			'showScriptName' => false,
			'rules' => [
				'<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
				'<_c:[\w\-]+>' => '<_c>/index',
				'<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_c>/<_a>',
			],
		],		
    ],
    'params' => $params,
];
