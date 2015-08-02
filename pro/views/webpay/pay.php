<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Оплата заказа N'.$order->id;

$params = \Yii::$app->params['payment_systems']['webpay'];


$wsb_storeid = $params['wsb_storeid'];
$wsb_store = $params['wsb_store'];
$wsb_order_num = $order->id;
$wsb_test = $params['wsb_test'];
$wsb_currency_id = $params['wsb_currency_id'];
$wsb_total = $order->fee;
$SecretKey = $params['SecretKey'];
$wsb_seed = rand().rand().rand().rand();
//$wsb_seed = '12372636817779752241725472594467028658';
$ts = $wsb_seed . $wsb_storeid . $wsb_order_num . $wsb_test . $wsb_currency_id . $wsb_total . $SecretKey;

$wsb_signature = sha1($ts);

//$wsb_signature = md5($ts);

$wsb_email = $order->user->email;

?>
<div class="site-index">

	<h1><?= $this->title?></h1>

	<p>Сейчас  Вы  будете  автоматически  переадресованы  на сервер оплаты Webpay, если этого не произошло нажмите на кнопку ниже.</p>
	<?php if($wsb_test == 1):?>
		<form ACTION="<?= $params['wsb_url_test']?>" METHOD="POST" name="formwebpay">
		<input NAME="wsb_test"  type="hidden" value="1">
	<?php else:?>
		<form ACTION="<?= $params['wsb_url']?>" METHOD="POST" name="formwebpay">
		<input NAME="wsb_test"  type="hidden" value="0">
	<?php endif;?>

		<input name="*scart"  type="hidden">
		<input name="wsb_storeid" type="hidden" value="<?=$wsb_storeid?>">
		<input name="wsb_store"  type="hidden" value="<?=$wsb_store?>" >
		<input NAME="wsb_order_num"  type="hidden" value="<?=$wsb_order_num?>">
		<input NAME="wsb_total"  type="hidden" value="<?=$wsb_total?>">
		<input NAME="wsb_currency_id"  type="hidden" value="<?=$wsb_currency_id?>" >
		<input NAME="wsb_version"  type="hidden" value="2">

		<input NAME="wsb_language_id"  type="hidden" value="russian">
		<input NAME="wsb_seed"  type="hidden" value="<?=$wsb_seed?>">	
		<input NAME="wsb_signature"  type="hidden" value="<?=$wsb_signature?>">

		<input NAME="wsb_return_url"  type="hidden" value="http://pro.team.by/webpay/complete.php">
		<input NAME="wsb_cancel_return_url"  type="hidden" value="http://pro.team.by/webpay/cancel.php">
		<input name="wsb_notify_url" type="hidden" value="http://pro.team.by/webpay/notify.php">

		<?php if($wsb_email != '')	{	?>
			<input NAME="wsb_email"  type="hidden" value="<?=$wsb_email?>">
		<?php	}	?>

		<input type="hidden" name="wsb_invoice_item_name[]" value="<?= $order->descr?>">
		<input type="hidden" name="wsb_invoice_item_quantity[]" value="1">
		<input type="hidden" name="wsb_invoice_item_price[]" value="<?= $order->fee?>">

		<br>
		<?/*<input type="Submit" value=" Оплатить ">*/?>
		<button class="button-red"> Оплатить </button>
	</form>
	
	<?/*<script>document.forms["formwebpay"].submit();</script> */?>
	        
</div>
