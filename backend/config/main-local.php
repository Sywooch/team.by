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
		'91.149.156.151',
		
	];
	
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = ['class' => \yii\debug\Module::className(), 'allowedIPs' => $allowedIPs];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = ['class' => \yii\gii\Module::className(), 'allowedIPs' => $allowedIPs];
}

return $config;
