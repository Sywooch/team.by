<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ButtonDropdown;

use yii\widgets\ActiveForm;

use yii\widgets\Pjax;

?>




<div class="profile_orders">
<?php $form = ActiveForm::begin(['id' => 'orders-sort-sw', 'options'=>['class'=>'orders-sort-sw ']]); ?>
	<input type="hidden" id="orderby" name="orderby" value="<?= $current_ordering['field']?>" />
<?php ActiveForm::end(); ?>

	<div class="profile_orders_row orders-sort-cnt">
		<p class="category-sort-lbl">Сортировать по:</p>
		<?php echo ButtonDropdown::widget([
			'label' => $current_ordering['name'],
			'options' => [
				'class' => 'btn-lg btn-link',
				'style' => ''
			],
			'containerOptions' => [
				'class' => 'sorting-switcher',
			],
			'dropdown' => [
				'items' => $ordering_items
			]
		]);
		?>
		
	</div>
	
	<?php Pjax::begin(); ?>
		<?php echo ListView::widget( [
			'dataProvider' => $dataProvider,
			'itemView' => '_item-order',
			'summary' => '',
			'id' => 'orders-list',
			'options' => ['class' => 'list-view profile-orders-list-view clearfix'],
			'itemOptions' => ['class'=>'profile_orders_row profile_order_item'],
			'layout' => '{items}{pager}',
			//'viewParams'=> ['specials'=>$specials],
		]);?>
	<?php Pjax::end(); ?>
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