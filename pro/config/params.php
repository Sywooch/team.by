<?php

return [
    'adminEmail' => 'aldegtyarev@yandex.ru',
	'homeUrl' => 'http://pro.team.by',
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
		'erip' => [],
	]
];
