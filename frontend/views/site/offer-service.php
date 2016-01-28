<?php

use yii\web\View;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $model frontend\models\ZakazSpec1 */
/* @var $form ActiveForm */

$this->title = 'Предложение новой услуги';

$this->registerJs("jQuery('#captcha-reload-bnt').on('click', function(){jQuery('#offerservicesform-verifycode-image').click()});", View::POS_READY, 'verifycode-image');
?>
<h1><?= Html::encode($this->title) ?></h1>
<?php if($show_form == 1)	{	?>
<div class="site-offer-service-modal width50">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'email') ?>
		<?= $form->field($model, 'comment') ?>
		<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
			'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-1"><img id="captcha-reload-bnt" src="http://team.by/images/reload-btn.png" title="Обновить картинку"></div><div class="col-lg-8">{input}</div></div>',
		]) ?>

		<div class="form-group cleafrix">
			<?= Html::submitButton('Отправить', ['id'=>'zakaz-spec1-btn', 'class' => 'button-red']) ?>
		</div>
	<?php ActiveForm::end(); ?>
</div><!-- site-offer-service-modal -->
<?php	}	?>