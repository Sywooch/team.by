<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ZakazSpec1 */
/* @var $form ActiveForm */

$this->title = 'Заявка на подбор профессионала';
?>

<div class="modal-dialog modal-dialog__zakaz-spec1 modal-content">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h2 class="h2__modal"><?= Html::encode($this->title) ?></h2>
		</div>
		
		<div class="modal-body">
			<?php $form = ActiveForm::begin(['action'=>['zakaz-spec1', 'modal'=>1]]); ?>
				<?= $form->field($model, 'user_id')->hiddenInput() ?>
				<?= $form->field($model, 'spec_name')->hiddenInput() ?>
				<?= $form->field($model, 'phone')->textInput(['class'=>'inputbox width100 phone-input']) ?>
				<?= $form->field($model, 'name') ?>
				<?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

				<div class="form-group cleafrix">
					<?= Html::submitButton('Отправить', ['id'=>'zakaz-spec1-btn', 'class' => 'button-red']) ?>
					<?/*<p class="catalog-zakaz-spec1-notice">Отправляя заявку, подтверждаю ознакомление и согласие с <a href="#" target="_blank">Условиями использования</a></p>*/?>
				</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>