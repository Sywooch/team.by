<?php
/* @var $this yii\web\View */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

// // Номер телефона=333333534, Сеансовый пароль=3797

$this->title = 'Оплата заказ N'.$orderNum;
?>
<div class="site-index">

        <h1><?= $this->title?></h1>
        
	<form id="pay-frm" action="https://stand.besmart.by:4443/pls/ipay/!iSOU.Login" method="post" role="form">

		<input type="hidden" id="ipayform-srv_no" class="form-control" name="srv_no" value="123">
		<input type="hidden" id="ipayform-pers_acc" class="form-control" name="pers_acc" value="<?= $orderNum?>">
		<input type="hidden" id="ipayform-amount" class="form-control" name="amount" value="<?= $order->fee ?>">
		<input type="hidden" id="ipayform-amount_editable" class="form-control" name="amount_editable" value="N">	
		<input type="hidden" id="ipayform-provider_url" class="form-control" name="provider_url" value="http://team.by/profile">
		<div class="form-group">
			<button type="submit" class="button-red">Продолжить</button>		
		</div>
	</form>
	        
</div>
