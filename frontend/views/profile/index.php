<?php
use yii\bootstrap\Tabs;


$title = 'Личный кабинет специалиста — '.$model->fio;
$this->title = $title;

$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет'];

?>

<div class="profile-page">

	<h1><?= $title?></h1>


	<div class="profile__tabs">
		<?php 
		echo Tabs::widget([
			'items' => [
				[
					'label' => 'Моя анкета',
					'content' => $this->render('_profile', ['model'=>$ProfileAnketaForm, 'categories' => $categories, 'categories_l3'=>$categories_l3], false, true),
					'active' => true,
					'linkOptions' => ['class' => 'profi_search_tabs__tab1'],
					'options' => ['class' => 'tab_profile_anketa']
				],
				[
					'label' => 'Мои заказы',
					'content' => $this->render('_orders', [], false, true),
					'linkOptions' => ['class' => 'profi_search_tabs__tab2'],
					'options' => ['class' => 'tab_profile_orders']
				],
				[
					'label' => 'Моё расписание',
					'content' => $this->render('_shedule', ['model' => $call_time, 'weekends' => $weekends], false, true),
					'linkOptions' => ['class' => 'profi_search_tabs__tab2'],
					'options' => ['class' => 'tab_profile__shedule']
				],
				[
					'label' => 'Мои отзывы',
					'content' => $this->render('_reviews', [], false, true),
					'linkOptions' => ['class' => 'profi_search_tabs__tab2'],
					'options' => ['class' => 'tab_profile__reviews']
				],
				[
					'label' => 'Способ оплаты',
					'content' => $this->render('_payment', [], false, true),
					'linkOptions' => ['class' => 'profi_search_tabs__tab2'],
					'options' => ['class' => 'tab_profile__payment']
				],
			]
		]);			

		?>        

	</div>
</div>