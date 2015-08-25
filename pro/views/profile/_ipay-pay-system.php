<?php
use yii\helpers\Url;
?>


<div class="tab_profile_anketa page-body">
	<?= $text?>
	
	<a href="<?= Url::to(['ipay_test/pay', 'id'=>$id])?>" class="button-red btn-short">Оплатить</a>
</div>