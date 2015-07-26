<?php
	use frontend\helpers\DPriceHelper;
?>


<div class="row clearfix">
	<div class="col-lg-2">
		<p class="profile_order_num">Заказ номер <?=$model->id?></p>
		
		<p class="profile_order_status <?= $model->orderPaymentStatusClass?>"><?= $model->orderPaymentStatusTxt?></p>
		<div class="profile_order_date">Дата <?php echo Yii::$app->formatter->asDate($model->created_at, 'php:d M Y'); ?></div>

	</div>
	<div class="col-lg-4">
		<p class="order_item_zakazchik"><span class="dinpro-b">Заказчик</span> <?=$model->client->fio?> <?=$model->client->info?></p>
		<p class="order_item_zakazchik_phone"><span class="dinpro-b">Телефон</span> <?=$model->client->phone?></p>
	</div>
	<div class="col-lg-4">
		<p class="order_item_rabota"><span class="dinpro-b">Вид работ</span> <?=$model->descr?></p>
		<p class="order_item_price"><span class="dinpro-b">Стоимость</span> <?= DPriceHelper::formatPrice($model->price, 1); ?></p>
	</div>
	<div class="col-lg-2">
		<?php if($model->fee)	{	?>
			<p class="order_item_fee order_item_fee_warning">Комиссия <?= DPriceHelper::formatPrice($model->fee, 1); ?></p>
			<a href="#" class="button-red btn-short">Оплатить</a>
		<?php	}	?>
	</div>
</div>
