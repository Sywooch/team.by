<?php
use yii\helpers\Url;

use frontend\widgets\Regions;
use frontend\widgets\Currency;

use yii\widgets\ActiveForm;

?>
<div class="header__row1">
	<div class="container clearfix">

		<?= Regions::widget() ?>

		<?= Currency::widget() ?>

		<div class="autorization_h">
			<ul class="autorization_h__list">
				<?php if (\Yii::$app->user->isGuest) {	?>
					<li class="autorization_h__item autorization_h__item_reg_spec"><a class="autorization_h__reg_spec" href="http://pro.team.by/site/reg">Стать специалистом</a></li>
				<?	}	else	{	?>
					<li class="autorization_h__item autorization_h__item_reg_spec">
						<?php $form = ActiveForm::begin(['action'=>['/site/logout']]); ?>						
							<a id="logout-btn" class="autorization_h__logout" href="<?= Url::toRoute('/site/logout')?>">Выйти из системы</a>
						<?php ActiveForm::end(); ?>
						
					</li>				
				<?	}	?>
				<?php if (\Yii::$app->user->isGuest) {	?>
					<li class="autorization_h__item autorization_h__item_login"><a id="login-modal" class="autorization_h__login" href="<?= Url::toRoute('/site/login')?>">Войти</a></li>
				<?	}	else	{	?>
					<li class="autorization_h__item autorization_h__item_login">
						<a class="autorization_h__login" href="http://pro.team.by/">Кабинет</a>						
						<div id="in_profile__popup" class="in_profile__popup popup_block">Вход в личный кабинет</div>
					</li>
				<?	}	?>
			</ul>
		</div>
	</div>
</div>
