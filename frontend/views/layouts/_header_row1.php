<?php
use yii\helpers\Url;

use frontend\widgets\Regions;
use frontend\widgets\Currency;

?>
<div class="header__row1">
	<div class="container clearfix">

		<?= Regions::widget() ?>

		<?= Currency::widget() ?>

		<div class="autorization_h">
			<ul class="autorization_h__list">
				<li class="autorization_h__item autorization_h__item_reg_spec"><a class="autorization_h__reg_spec" href="<?= Url::toRoute('/site/reg')?>">Стать специалистом</a></li>
				<li class="autorization_h__item autorization_h__item_login"><a id="login-modal" class="autorization_h__login" href="<?= Url::toRoute('/site/login')?>">Войти</a></li>
			</ul>
		</div>
	</div>
</div>
