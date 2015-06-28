<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<div class="currency_select">
	<p class="currency_select__ttl">Выбор валюты:</p>
	<div class="currency_select__list_cnt">
		<?php $form = ActiveForm::begin(['action'=>\Yii::$app->urlManager->createUrl(['site/set-currency']), 'id'=>'set-currency-frm']); ?>
			<input type="hidden" name="return_url" value="<?= Url::to('')?>">
			<input type="hidden" id="currency_id" name="currency_id" value="<?= $currency_id?>">
		
			<ul class="currency_select__list">
				<li><a href="javascript:void(0)" class="currency_select__item currency_select__byr <?php if($currency_id == 1) echo 'currency_select__byr_active'?>" data-currency="1">BYR</a></li>
				<li id="currency_select__usd"><a href="javascript:void(0)" class="currency_select__item currency_select__usd <?php if($currency_id == 2) echo 'currency_select__usd_active'?>" data-currency="2">USD</a></li>
			</ul>
		<?php ActiveForm::end(); ?>			
	</div>
	<div id="currency_select__popup" class="currency_select__popup popup_block">
		Информация в USD приво- дится только для справки. Все расчеты происходят в белорусских рублях.
	</div>
</div>
