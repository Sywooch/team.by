<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '-GsUn9eP5X00btp8kBOc3JjCMXNl6vY5',
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
		'178.121.77.152',
		'178.121.95.135',
		'93.125.44.135',
		
	];
	
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = ['class' => \yii\debug\Module::className(), 'allowedIPs' => $allowedIPs];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = ['class' => \yii\gii\Module::className(), 'allowedIPs' => $allowedIPs];
}

return $config;
