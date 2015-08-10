<?php
use yii\helpers\Html;

$xml = '<ServiceProvider_Request>
<Version>1</Version>
<RequestType>TransactionStart</RequestType>
<DateTime>20090124153856</DateTime>
<PersonalAccount>100000</PersonalAccount>
<Currency>974</Currency>
<RequestId>9221</RequestId>
<TransactionStart>
<Amount>10000</Amount>
<TransactionId>6180433</TransactionId>
<Agent>999</Agent>
<AuthorizationType Ident="375297777777">iPay</AuthorizationType>
</TransactionStart>
</ServiceProvider_Request>';

$xml = addslashes('<?xml version="1.0" encoding="windows-1251" ?>
<ServiceProvider_Request>
<DateTime>20150730185213</DateTime>
<Version>1</Version>
<RequestType>ServiceInfo</RequestType>
<PersonalAccount>313132</PersonalAccount>
<Currency>974</Currency>
<RequestId>36829</RequestId>
<ServiceInfo>
  <Agent>369</Agent>
</ServiceInfo>
</ServiceProvider_Request>');


$salt = addslashes('Ytrd7dhghfb787dcjd64vs7');

$md5 = md5($salt . $xml);
header("ServiceProvider-Signature: SALT+MD5: $md5");

?>


<form action="http://pro.team.by/ipay_test/service_info" method="post">
	<input type="hidden" name="XML" value="<?= Html::encode($xml)?>" />
	<input type="submit" value="go">
	
</form>



<?/*
<form action="http://pro.team.by/webpay/notify.php" method="post">
	<input type="hidden" name="" value="" />
	<input type="submit" value="go">
	
</form>
*/?>