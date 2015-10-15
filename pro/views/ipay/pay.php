<?php
/* @var $this yii\web\View */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

// // Номер телефона=333333534, Сеансовый пароль=3797

$this->title = 'Оплата заказ N'.$orderNum;
?>
<div class="site-index">

	<h1><?= $this->title?></h1>
       
	<p>Все готово для оплаты.</p><br><br><br>  
    <?php	if(\Yii::$app->params['payment_systems']['erip']['test_mode'] == 1)	{	?>    
		<form id="pay-frm" action="<?= \Yii::$app->params['payment_systems']['erip']['form_url']?>" method="post" role="form">

			<input type="hidden" id="ipayform-srv_no" class="form-control" name="srv_no" value="123">
			<input type="hidden" id="ipayform-pers_acc" class="form-control" name="pers_acc" value="<?= $orderNum?>">
			<input type="hidden" id="ipayform-amount" class="form-control" name="amount" value="<?= $order->fee ?>">
			<input type="hidden" id="ipayform-amount_editable" class="form-control" name="amount_editable" value="N">	
			<input type="hidden" id="ipayform-provider_url" class="form-control" name="provider_url" value="<?= \Yii::$app->params['proUrl'] ?>">
			<div class="form-group">
				<button type="submit" class="button-red">Продолжить</button>
				<a href="<?= \Yii::$app->params['proUrl'] ?>" class="button-red">Вернуться в личный кабинет</a>
			</div>
		</form>
	<?php	}	else	{	?>
		<form id="pay-frm" action="<?= \Yii::$app->params['payment_systems']['erip']['form_url_life']?>" method="post" role="form">
			<input type="hidden" id="ipayform-srv_no" class="form-control" name="srv_no" value="123">
			<input type="hidden" id="ipayform-pers_acc" class="form-control" name="pers_acc" value="<?= $orderNum?>">
			<input type="hidden" id="ipayform-amount" class="form-control" name="amount" value="<?= $order->fee ?>">
			<input type="hidden" id="ipayform-amount_editable" class="form-control" name="amount_editable" value="N">	
			<input type="hidden" id="ipayform-provider_url" class="form-control" name="provider_url" value="<?= \Yii::$app->params['proUrl'] ?>">
			<div class="form-group">
				<button type="submit" style="background:none;border:none;"><img alt="" src="https://pro.team.by/files/global/iPay_life_720X384px.png" style="height:107px; width:200px"></button>
			</div>
		</form>
		
		<br>
		<br>
		
		<form id="pay-frm" action="<?= \Yii::$app->params['payment_systems']['erip']['form_url_mts']?>" method="post" role="form">
			<input type="hidden" id="ipayform-srv_no" class="form-control" name="srv_no" value="123">
			<input type="hidden" id="ipayform-pers_acc" class="form-control" name="pers_acc" value="<?= $orderNum?>">
			<input type="hidden" id="ipayform-amount" class="form-control" name="amount" value="<?= $order->fee ?>">
			<input type="hidden" id="ipayform-amount_editable" class="form-control" name="amount_editable" value="N">	
			<input type="hidden" id="ipayform-provider_url" class="form-control" name="provider_url" value="<?= \Yii::$app->params['proUrl'] ?>">
			<div class="form-group">
				<button type="submit" style="background:none;border:none;"><img alt="" src="https://pro.team.by/files/global/iPay_mts_720X384px.png" style="height:107px; width:200px"></button>
				
			</div>
		</form>
		
		<br>
		<br>
		<br>
		
		<a href="<?= \Yii::$app->params['proUrl'] ?>" class="button-red">Вернуться в личный кабинет</a>
	
	<?php	}	?>
	        
</div>
