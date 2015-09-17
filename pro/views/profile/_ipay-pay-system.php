<?php
use yii\helpers\Url;
?>


<div class="tab_profile_anketa page-body">
	<?= \common\helpers\DImageHelper::processImagesToHttps($text)?>
	
	<a href="<?= Url::to(['ipay/pay', 'id'=>$id])?>" class="button-red btn-short">Оплатить</a>
</div>