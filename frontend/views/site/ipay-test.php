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

?>

<?/*
<form action="http://pro.team.by/ipay_test/transaction_start.php" method="post">
	<input type="hidden" name="XML" value="<?= Html::encode($xml)?>" />
	<input type="submit" value="go">
	
</form>

*/?>


<form action="http://pro.team.by/webpay/notify.php" method="post">
	<input type="hidden" name="" value="" />
	<input type="submit" value="go">
	
</form>