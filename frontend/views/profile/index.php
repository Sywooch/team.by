<?php
use yii\bootstrap\Tabs;


$title = 'Личный кабинет специалиста — '.$model->fio;
$this->title = $title;

?>


<h1><?= $title?></h1>


<div class="profile__tabs">
	<?php 
	echo Tabs::widget([
		'items' => [
			[
				'label' => 'Моя анкета',
				'content' => $this->render('_profile', ['model'=>$ProfileAnketaForm, 'categories' => $categories], false, true),
				'active' => true,
				'linkOptions' => ['class' => 'profi_search_tabs__tab1'],
			],
			[
				'label' => 'Мои заказы',
				'content' => $this->render('_orders', [], false, true),
				'linkOptions' => ['class' => 'profi_search_tabs__tab2'],
				'options' => ['class' => 'profi_search_tab__zakaz']
			],
			[
				'label' => 'Моё расписание',
				'content' => $this->render('_shedule', [], false, true),
				'linkOptions' => ['class' => 'profi_search_tabs__tab2'],
				'options' => ['class' => 'profi_search_tab__zakaz']
			],
			[
				'label' => 'Мои отзывы',
				'content' => $this->render('_reviews', [], false, true),
				'linkOptions' => ['class' => 'profi_search_tabs__tab2'],
				'options' => ['class' => 'profi_search_tab__zakaz']
			],
			[
				'label' => 'Способ оплаты',
				'content' => $this->render('_payment', [], false, true),
				'linkOptions' => ['class' => 'profi_search_tabs__tab2'],
				'options' => ['class' => 'profi_search_tab__zakaz']
			],
		]
	]);			

	?>        

</div>
