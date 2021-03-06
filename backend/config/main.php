<?php
use developeruz\db_rbac\behaviors\AccessBehavior;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'permit' => [
            'class' => 'developeruz\db_rbac\Yii2DbRbac',
        ],		
//        'permit' => [
//            'class' => 'app\modules\db_rbac\Yii2DbRbac',
//            'params' => [
//                'userClass' => 'app\models\User'
//            ]
//        ],		
	],
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
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [
				'<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
				'<_c:[\w\-]+>' => '<_c>/index',
				'<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_c>/<_a>',
				'<_c:[\w\-]+>/<_a:[\w\-]+>/<date:[\w\-]+>' => '<_c>/<_a>',
				
//				'<module:\w+>/<controller:\w+>/<action:(\w|-)+>' => '<module>/<controller>/<action>',
//				'<module:\w+>/<controller:\w+>/<action:(\w|-)+>/<id:\d+>' => '<module>/<controller>/<action>',				
				
			],
		],
		
		'urlManagerFrontEnd' => [
			'class' => 'yii\web\urlManager',
			'baseUrl' => 'http://team.by',
		],
		
    ],
    'params' => $params,
	
	'controllerMap' => [
			'elfinder' => [
				'class' => 'mihaildev\elfinder\Controller',
				'access' => ['@'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
				'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
				'roots' => [
					[
						//'baseUrl'=>'@web',
						'baseUrl'=>'http://team.by',
						//'baseUrl'=>'/frontend/web',
						//'basePath'=>'@webroot',
						'basePath'=>'@frontend/web',
						//'basePath'=>$_SERVER['DOCUMENT_ROOT'].'/frontend/web',
						'path' => 'files/global',
						'name' => 'Global'
					],
					/*
					[
						'class' => 'mihaildev\elfinder\UserPath',
						'path'  => 'files/user_{id}',
						'name'  => 'My Documents'
					],
					/*
					[
						'path' => 'files/some',
						'name' => ['category' => 'my','message' => 'Some Name'] //перевод Yii::t($category, $message)
					],
					
					[
						'path'   => 'files/some',
						'name'   => ['category' => 'my','message' => 'Some Name'], // Yii::t($category, $message)
						'access' => ['read' => '*', 'write' => 'UserFilesAccess'] // * - для всех, иначе проверка доступа в даааном примере все могут видет а редактировать могут пользователи только с правами UserFilesAccess
					]
					*/
				],
				/*
				'watermark' => [
						'source'         => __DIR__.'/logo.png', // Path to Water mark image
						 'marginRight'    => 5,          // Margin right pixel
						 'marginBottom'   => 5,          // Margin bottom pixel
						 'quality'        => 95,         // JPEG image save quality
						 'transparency'   => 70,         // Water mark image transparency ( other than PNG )
						 'targetType'     => IMG_GIF|IMG_JPG|IMG_PNG|IMG_WBMP, // Target image formats ( bit-field )
						 'targetMinPixel' => 200         // Target image minimum pixel size
				]
				*/
			]
		],	
	/*
	'as AccessBehavior' => [
		'class' => AccessBehavior::className(),
        'rules' => [
			'site' =>	[	//controller
				[
					'actions' => ['login', 'logout', 'index'],
					'allow' => true,
				],
				[
					'actions' => ['about'],
					'allow' => true,
					'roles' => ['admin'],
				],
			],
			
			'category' =>	[	//controller
				[
					'actions' => ['index', 'create', 'update', 'delete', 'moveup', 'movedown', 'nameupdate'],
					'allow' => true,
					'roles' => ['admin'],					
				],
			],
			
			'region' =>	[	//controller
				[
					'actions' => ['index', 'create', 'update', 'delete', 'moveup', 'movedown'],
					'allow' => true,
					'roles' => ['admin'],					
				],
			],
			
			'order' =>	[	//controller
				[
					'actions' => ['index', 'payed', 'create', 'update', 'delete'],
					'allow' => true,
					'roles' => ['admin'],					
				],
			],
			
			'spec' =>	[	//controller
				[
					'actions' => ['index', 'create', 'update', 'delete'],
					'allow' => true,
					'roles' => ['admin'],					
				],
			],
			
			'client' =>	[	//controller
				[
					'actions' => ['index', 'create', 'update', 'delete', 'export-csv', 'export-go'],
					'allow' => true,
					'roles' => ['admin'],					
				],
			],
			
			'currency' =>	[	//controller
				[
					'actions' => ['index', 'create', 'update', 'delete'],
					'allow' => true,
					'roles' => ['admin'],					
				],
			],
			
			'toadministration' =>	[	//controller
				[
					'actions' => ['index', 'create', 'update', 'delete'],
					'allow' => true,
					'roles' => ['admin'],					
				],
			],
			
			'notify' =>	[	//controller 
				[
					'actions' => ['index', 'create', 'update', 'delete', 'to-spec', 'to-spec-add'],
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
			 
			'ajax' => [	//controller
				[
					'actions' => ['upload-review-foto'],
					'allow' => true,
					'roles' => ['admin'],
				],
			],
			 
			'page' => [	//controller
				[
					'actions' => ['index'],
					'allow' => true,
					'roles' => ['manager'],
				],
				[
					'actions' => ['index', 'view', 'create', 'update'],
					'allow' => true,
					'roles' => ['admin'],
				],
			],
			 
			'sheduler' => [	//controller
				[
					'actions' => ['index'],
					'allow' => true,
					'roles' => ['manager'],
				],
				[
					'actions' => ['index', 'orders', 'specs'],
					'allow' => true,
					'roles' => ['admin'],
				],
			],
			 
			'permit/access' => [	//controller
				[
					'actions' => ['role', 'add-role', 'update-role', 'delete-role', 'permission', 'add-permission', 'update-permission', 'delete-permission'],
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
			
			'elfinder' =>	[	//controller
				[
					'actions' => ['index','manager','connect'],
					'allow' => true,
					'roles' => ['admin'],
				],
			],
			
			
			 
		],	
		
	],
	/**/
	
];