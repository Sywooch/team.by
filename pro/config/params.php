	<?php

return [
    //'adminEmail' => 'aldegtyarev@yandex.ru',
    //'adminEmail' => 'alfonsovich@yandex.by',
	//'noreplyEmail' => 'noreply@team.by',
	'payment_systems' => [
		'webpay' => [
			'wsb_test' => 1,				//включен ли тестовый режим
			'wsb_storeid' => '479194313', 	//Идентификатор магазина в системе WebPay™. Данный идентификатор создается при регистрации в системе WebPay™ и высылается в письме.
			'wsb_store' => 'pro.team.by',	//Название магазина, которое будет отображаться на форме оплаты. По умолчанию берется из настроек биллинг аккаунта.			
			'wsb_currency_id' => 'BYR',		//Идентификатор валюты. Буквенный трехзначный код валюты согласно ISO4271
			'SecretKey' => 'A@oI{si',		// Секретный ключ
			'wsb_username' => 'team',		// имя пользователя  в системе WebPay
			'wsb_password' => 'oZOCiijnx=(',	//пароль
			'wsb_url' => 'https://secure.webpay.by',
			'wsb_url_test' => 'https://securesandbox.webpay.by',
			
			'wsb_url_check_trans' => 'https://billing.webpay.by',	//урлы для проверки транзакций
			'wsb_url_test_check_trans' => 'https://sandbox.webpay.by',
		],
		'erip' => [
			//'salt' => 'Ytrd7dhghfb787dcjd64vs7',
			'salt' => 'Ytrd7dhghfb787dcjd64vs7',
			//'salt' => 'c2sd68g7THDx',
			'form_url' => 'https://stand.besmart.by:4443/pls/ipay/!iSOU.Login'	//url куда данные отправляются
		],
	],
	
	'orderlist-orderby' => [
		'created_at' => 'дате добавления',
		'payment_status'	 => 'статусу',
	],
	
	'call_time_from' => 8,	//время для связи
	'call_time_to' => 22,
	
	
];
