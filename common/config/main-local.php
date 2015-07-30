<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=team_db',
            'username' => 'team_db',
            'password' => 'iJC18!o1',
            'charset' => 'utf8',
			'tablePrefix' => 'abc_',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
			'transport' => [
				'class' => 'Swift_SmtpTransport',
				'host' => 'mail.team.by',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
				'username' => 'noreply@team.by',
				'password' => 'sSY27#x1',
				'port' => '25', // Port 25 is a very common port too
				//'encryption' => 'ssl', // It is often used, check your provider or mail server specs			
				//'encryption' => 'tls', // It is often used, check your provider or mail server specs			
			],
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
				NumberFormatter::MAX_FRACTION_DIGITS => 2,
			],
		],	
		
    ],
];
