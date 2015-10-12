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
	
	'max-image-res' => [	// минимальные размеры фото
		'width' => 1024,
		'height' => 768,
	],
	
	'min-avatar-res' => [	// минимальные размеры фото для аватара
		'width' => 400,
		'height' => 400,
	],
	
	'image-res' => [	// размеры фото, до которого они будут уменьшаться
		'width' => 1366,
		'height' => 768,
	],
];
