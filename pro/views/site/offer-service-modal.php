<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $model frontend\models\ZakazSpec1 */
/* @var $form ActiveForm */

$this->title = 'Предложение новой услуги';
?>

<div class="modal-dialog site-offer-service-modal modal-content">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h2 class="h2__modal"><?= Html::encode($this->title) ?></h2>
		</div>
		
		<div class="modal-body">
			<?php $form = ActiveForm::begin(['action'=>['zakaz-spec1', 'modal'=>1]]); ?>
			
				<?= $form->field($model, 'email') ?>
				<?= $form->field($model, 'comment') ?>
				<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
					'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-1"><img id="captcha-reload-bnt" src="http://team.by/images/reload-btn.png" title="Обновить картинку"></div><div class="col-lg-8">{input}</div></div>',
					//'captchaAction' => "http://team.by/site/captcha",
				]) ?>

				<div class="form-group cleafrix">
					<?= Html::submitButton('Отправить', ['id'=>'zakaz-spec1-btn', 'class' => 'button-red']) ?>
				</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div><!-- site-offer-service-modal -->

<script src="/assets/dd5f9f45/yii.captcha.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function () {
		jQuery('#offerservicesform-verifycode-image').yiiCaptcha({
			"refreshUrl":"\/site\/captcha?refresh=1",
			//"refreshUrl":"https:\/\/team.by\/site\/captcha?refresh=1",
			"hashKey":"yiiCaptcha\/site\/captcha"
			//"hashKey":"yiiCaptcha\/https:\/\/team.by\/site\/captcha"
		});
		jQuery('#captcha-reload-bnt').on('click', function(){
			jQuery('#offerservicesform-verifycode-image').click()
			//jQuery('#offerservicesform-verifycode-image').attr('src', ('https://team.by/' + jQuery('#offerservicesform-verifycode-image').attr('src')))
		});
	});
	
</script>