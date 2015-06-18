<?php
use developeruz\db_rbac\behaviors\AccessBehavior;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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
    ],
    'params' => $params,
	
	'as AccessBehavior' => [
		'class' => AccessBehavior::className(),
        'rules' => [
			'site' =>	[	//controller
				[
					'actions' => ['login', 'index'],
					'allow' => true,
				],
				[
					'actions' => ['about'],
					'allow' => true,
					'roles' => ['admin'],
				],
			],
			
			'post' => [	//controller
				[
					'actions' => ['index'],
					'allow' => true,
					'roles' => ['admin'],
				],
			],
			
			'debug/default' => [	//controller
				[
					'actions' => ['toolbar', 'index', 'view'],
					'allow' => true,
				],
			],
			
			 
		],	
		
	],	
	
];
