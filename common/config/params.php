<?php
return [
	'homeUrl' => 'http://team.by',
	'proUrl' => 'https://pro.team.by',
	'admPanelUrl' => 'http://adm.team.by',
	
   	//'adminEmail' => 'aldegtyarev@yandex.ru',
    'adminEmail' => 'alfonsovich@yandex.by',

    'supportEmail' => 'support@example.com',
    'noreplyEmail' => 'noreply@team.by',
    'user.passwordResetTokenExpire' => 3600,
    'sitename' => 'Команда профессионалов',
	'UserTypesArray' => [
		1 => 'Физическое лицо',
		2 => 'Юридическое лицо',
		3 => 'ИП',
	],
	'avatars-path' => 'files/users/avatars',
	'awards-path' => 'files/users/awards',
	'examples-path' => 'files/users/examples',
	'pricelists-path' => 'files/users/pricelists',
	'reviews-path' => 'files/users/reviews',
	'licenses-path' => 'files/users/licenses',
	'documents-path' => 'files/users/documents',
	
	'export-path' => 'files/export',
	
	'max-image-res' => [	// максимальные размеры фото
		'width' => 3300,
		'height' => 2500,
	],
	
	'min-image-res' => [	// минимальные размеры фото
		'width' => 1024,
		'height' => 768,
	],
	
	'min-avatar-res' => [	// минимальные размеры фото для аватара
		'width' => 400,
		'height' => 400,
	],
	
	'image-res' => [	// размеры фото, до которого они будут уменьшаться
		'width' => 1024,
		'height' => 768,
	],
	
	'payment_systems' => [
		'webpay' => [
			'wsb_test' => 0,				//включен ли тестовый режим
			//'wsb_storeid' => '479194313', 	//Идентификатор магазина в системе WebPay™. Данный идентификатор создается при регистрации в системе WebPay™ и высылается в письме.
			'wsb_storeid' => '185035259', 	//Идентификатор магазина в системе WebPay™. Данный идентификатор создается при регистрации в системе WebPay™ и высылается в письме.
			
			'wsb_store' => 'pro.team.by',	//Название магазина, которое будет отображаться на форме оплаты. По умолчанию берется из настроек биллинг аккаунта.			
			
			'wsb_currency_id' => 'BYR',		//Идентификатор валюты. Буквенный трехзначный код валюты согласно ISO4271
			
			//'SecretKey' => 'A@oI{si',		// Секретный ключ для тестовой среды
			'SecretKey' => 'ahY3vPO~%CRzd',		// Секретный ключ тестовой среды
			
			//'wsb_username' => 'team',		// имя пользователя  в системе WebPay для тестовой среды
			'wsb_username' => 'pro.team',		// имя пользователя  в системе WebPay
			
			//'wsb_password' => 'oZOCiijnx=(',	//пароль для тестовой среды
			'wsb_password' => 'WNXJyi,ttOR',	//пароль
			
			'wsb_url' => 'https://secure.webpay.by',
			'wsb_url' => 'https://payment.webpay.by',
			
			'wsb_url_test' => 'https://securesandbox.webpay.by',
			
			'wsb_url_check_trans' => 'https://billing.webpay.by',	//урлы для проверки транзакций
			'wsb_url_test_check_trans' => 'https://sandbox.webpay.by',
		],
		'erip' => [
			'test_mode' => 0,
			//'salt' => 'Ytrd7dhghfb787dcjd64vs7',
			'salt' => 'c2sd68g7THDx',
			'form_url' => 'https://stand.besmart.by:4443/pls/ipay/!iSOU.Login',	//url куда данные отправляются для отладки
			'form_url_mts' => 'https://mts.ipay.by:4443/pls/iPay/!iSOU.Login?srv_no=4334461',	//url куда данные отправляются для МТС
			'form_url_life' => 'https://gate.besmart.by/ipaylife/!iSOU.Login?srv_no=4334461',	//url куда данные отправляются для LIFE
		],
	],
	
];
