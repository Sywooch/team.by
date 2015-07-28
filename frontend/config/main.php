<?php
use developeruz\db_rbac\behaviors\AccessBehavior;
use frontend\components\AUrlManager;

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
		'urlManager' => [
			'class'=>'frontend\components\AUrlManager',
			
			'enablePrettyUrl' => true,
			//'enableStrictParsing' => true,
			'showScriptName' => false,
			'rules' => [
				'catalog/search/page/<page:[\d]+>'=>'catalog/search',
				'catalog/black-list/page/<page:[\d]+>'=>'catalog/black-list',
				
				'catalog/<category:[\w_\/-]+>/page/<page:[\d]+>'=>'catalog/category',
				
				'catalog/<category:[\w_\/-]+>/<id:[\d]+>'=>'catalog/show',
				
				'catalog/black-list'=>'catalog/black-list',
				'catalog/search'=>'catalog/search',
				
				'catalog/<category:[\w_\/-]+>'=>'catalog/category',
				
				'catalog'=>'catalog/index',
				
				'<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
				'<_c:[\w\-]+>' => '<_c>/index',
				'<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_c>/<_a>',
			],
		],		
    ],
    'params' => $params,
	/*
	'as AccessBehavior' => [
		'class' => AccessBehavior::className(),
        'rules' => [
			'site' =>	[	//controller
				[
					'actions' => ['login', 'index', 'signup'],
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
		
	],	*/
	
];
