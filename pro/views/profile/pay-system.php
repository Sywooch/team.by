<?php
use yii\bootstrap\Tabs;


$title = 'Выбор способа оплаты';
$this->title = \Yii::$app->params['sitename'] .' | ' . $title;

$this->params['breadcrumbs'] = [
	['label' => 'Личный кабинет', 'url' => '/profile'],
	['label' => $title]
];

?>

<div class="profile-page">

	<h1><?= $title?></h1>


	<div class="profile__tabs">
		<?php 
		echo Tabs::widget([
			'items' => [
				[
					'label' => 'ЕРИП',
					'content' => $this->render('_erip-pay-system', ['id' => $id], false, true),
					'linkOptions' => ['class' => 'profi_search_tabs__tab2'],
					'options' => ['class' => 'tab_profile_orders']
				],
				[
					'label' => 'iPay',
					'content' => $this->render('_ipay-pay-system', ['id' => $id], false, true),
					'linkOptions' => ['class' => 'profi_search_tabs__tab2'],
					'options' => ['class' => 'tab_profile_orders']
				],
				[
					'label' => 'Оплата банковской картой',
					'content' => $this->render('_webpay-pay-system', ['id' => $id], false, true),
					'linkOptions' => ['class' => 'profi_search_tabs__tab2'],
					'options' => ['class' => 'tab_profile_orders']
				],
				[
					'label' => 'Перевод на счет с указанием номера заказа',
					'content' => $this->render('_transfer-pay-system', ['id' => $id], false, true),
					'linkOptions' => ['class' => 'profi_search_tabs__tab2'],
					'options' => ['class' => 'tab_profile_orders']
				],
			]
		]);			

		?>        

	</div>
</div>