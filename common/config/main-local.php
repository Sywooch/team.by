<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=gfclubne_orisad',
            'username' => 'gfclubne_orisad',
            'password' => 'wkd?S#}nDVFk',
            'charset' => 'utf8',
			'tablePrefix' => 'abc_',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
		'authManager' => [
			'class' => 'yii\rbac\DbManager',
		],		
		'formatter' => [
			'dateFormat' => 'd/m/Y',
			'timeFormat' => 'H:i:s',
			'datetimeFormat' => 'd/m/Y H:i:s',
			'decimalSeparator' => ',',
			'thousandSeparator' => ' ',
			
			'numberFormatterOptions' => [
				NumberFormatter::MIN_FRACTION_DIGITS => 0,
				NumberFormatter::MAX_FRACTION_DIGITS => 0,
			],
		],	
		
    ],
];
