<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ButtonDropdown;

use yii\widgets\ActiveForm;

?>




<div class="profile_orders">

<?
	//echo'<pre>';print_r($dataProvider->models);echo'</pre>';
	?>
	<div class="profile_orders_row">
		Сортировать по
	</div>
	
	<?php
	echo ListView::widget( [
		'dataProvider' => $dataProvider,
		'itemView' => '_item-order',
		'summary' => '',
		'id' => 'items-list',
		'options' => ['class' => 'list-view profile-orders-list-view'],
		'itemOptions' => ['class'=>'profile_orders_row profile_order_item'],
		'layout' => '{items}{pager}',
		//'viewParams'=> ['specials'=>$specials],
	] );
	?>
	<?/*
	<div class="profile_orders_row profile_order_item">
		<div class="row clearfix">
			<div class="col-lg-2">
				<p class="profile_order_num">Заказ номер 3</p>
				<p class="profile_order_status order_status_warning">Статус просрочена</p>
				<div class="profile_order_date">Дата 22 марта 2016г</div>
				
			</div>
			<div class="col-lg-4">
				<p class="order_item_zakazchik"><span class="dinpro-b">Заказчик</span> Сокольников Николай Компания Лосины и Молнии</p>
				<p class="order_item_zakazchik_phone"><span class="dinpro-b">Телефон</span> 8 033 837 89 45</p>
			</div>
			<div class="col-lg-4">
				<p class="order_item_rabota"><span class="dinpro-b">Вид работ</span> Облицовка и остекленение</p>
				<p class="order_item_price"><span class="dinpro-b">Стоимость</span> 8 150 000 руб</p>
			</div>
			<div class="col-lg-2">
				<p class="order_item_fee order_item_fee_warning">Комиссия 100 000 руб</p>
				<a href="#" class="button-red btn-short">Оплатить</a>
			</div>
		</div>
	</div>
	
	<div class="profile_orders_row profile_order_item">
		<div class="row clearfix">
			<div class="col-lg-2">
				<p class="profile_order_num">Заказ номер 2</p>
				<p class="profile_order_status order_status_ok">Статус оплачена</p>
				<div class="profile_order_date">Дата 22 марта 2016г</div>
				
			</div>
			<div class="col-lg-4">
				<p class="order_item_zakazchik"><span class="dinpro-b">Заказчик</span> Сокольников Николай Компания Лосины и Молнии</p>
				<p class="order_item_zakazchik_phone"><span class="dinpro-b">Телефон</span> 8 033 837 89 45</p>
			</div>
			<div class="col-lg-4">
				<p class="order_item_rabota"><span class="dinpro-b">Вид работ</span> Облицовка и остекленение</p>
				<p class="order_item_price"><span class="dinpro-b">Стоимость</span> 8 150 000 руб</p>
			</div>
			<div class="col-lg-2">
				<p class="order_item_fee">Комиссия 100 000 руб</p>
			</div>
		</div>
	</div>
	
	<div class="profile_orders_row profile_order_item">
		<div class="row clearfix">
			<div class="col-lg-2">
				<p class="profile_order_num">Заказ номер 1</p>
				<p class="profile_order_status order_status_wait">Статус ожидает</p>
				<div class="profile_order_date">Дата 22 марта 2016г</div>
				
			</div>
			<div class="col-lg-4">
				<p class="order_item_zakazchik"><span class="dinpro-b">Заказчик</span> Сокольников Николай Компания Лосины и Молнии</p>
				<p class="order_item_zakazchik_phone"><span class="dinpro-b">Телефон</span> 8 033 837 89 45</p>
			</div>
			<div class="col-lg-4">
				<p class="order_item_rabota"><span class="dinpro-b">Вид работ</span> Облицовка и остекленение</p>
				<p class="order_item_price"><span class="dinpro-b">Стоимость</span> 8 150 000 руб</p>
			</div>
			<div class="col-lg-2">
				<p class="order_item_fee">Комиссия 100 000 руб</p>
				<a href="#" class="button-red btn-short">Оплатить</a>
			</div>
		</div>
	</div>
	*/?>
	
</div>