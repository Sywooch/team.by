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
