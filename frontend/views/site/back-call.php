<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ZakazSpec1 */
/* @var $form ActiveForm */

$this->title = 'Обратный звонок';
?>

<div class="modal-dialog modal-dialog__zakaz-spec1 modal-content">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h2 class="h2__modal"><?= Html::encode($this->title) ?></h2>
		</div>
		
		<div class="modal-body">
			<?php $form = ActiveForm::begin(); ?>
			    <div class="row">
			        <div class="col-lg-6"><?= $form->field($model, 'phone')->textInput(['placeholder'=>'Номер телефона', 'class'=>'form-control']) ?></div>
			        <div class="col-lg-6"><?= $form->field($model, 'name') ?></div>
			    </div>
				
				

				<div class="form-group cleafrix text_c">
					<?= Html::submitButton('Отправить', ['id'=>'back-call-btn', 'class' => 'button-red']) ?>
				</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>