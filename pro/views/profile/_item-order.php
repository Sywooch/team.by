<?php
use yii\helpers\Url;
use common\helpers\DPriceHelper;
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
			<?php if($model->payment_status == 10)	{	?>
				<p class="order_item_fee order_item_fee_payed">Комиссия <?= DPriceHelper::formatPrice($model->fee, 1); ?></p>
				<?php	}	else	{	?>

				<p class="order_item_fee order_item_fee_warning">Комиссия <?= DPriceHelper::formatPrice($model->fee, 1); ?></p>
				<?php 
					switch($model->user->payment_type)	{
						case 1:
							$payment_url = 'http://pro.team.by/webpay/pay/'.$model->id;
							break;
						case 2:
							$payment_url = 'http://pro.team.by/ipay_test/pay/'.$model->id;
							break;
					}	
				?>
					<a href="<?= Url::to(['profile/pay-system', 'id'=>$model->id])?>" class="button-red btn-short">Оплатить</a>
			<?php	}	?>
		<?php	}	?>
	</div>
</div>
