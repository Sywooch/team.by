<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'gnt5dPkcgjD7PyisxkTZ_XZInSq2zlf4',
        ],
    ],
];

if (!YII_ENV_TEST) {
	$allowedIPs = [
		'178.121.157.86',
		'93.125.76.35',
		'93.125.76.42',
		'93.125.44.79',
		'93.125.72.141',
		'93.125.72.12',
		'93.125.72.108',
		'93.125.76.148',
		'93.125.44.20',
		'93.125.76.159',
		'93.125.72.191',
		'93.125.76.66',
		'178.121.41.86',
		'178.121.119.241',
		'93.125.72.178',
		'93.125.72.251',
		'178.121.175.151',
		'91.149.156.221',
		'178.121.95.135',
		'178.121.150.15',
		'178.121.151.95',
		
	];
	
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    //$config['modules']['debug'] = 'yii\debug\Module';
	$config['modules']['debug'] = ['class' => \yii\debug\Module::className(), 'allowedIPs' => $allowedIPs];

    $config['bootstrap'][] = 'gii';
    //$config['modules']['gii'] = 'yii\gii\Module';
	$config['modules']['gii'] = ['class' => \yii\gii\Module::className(), 'allowedIPs' => $allowedIPs];
}

return $config;
