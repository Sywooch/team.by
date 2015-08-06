<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\AddAnswerReviewForm */
/* @var $form ActiveForm */

$this->title = 'Ответ на отзыв';
?>
<div class="modal-dialog modal-dialog__profile-add-answer modal-content">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h2 class="h2__modal"><?= Html::encode($this->title) ?></h2>
		</div>
		
		<div class="modal-body">
			<?php $form = ActiveForm::begin(); ?>

				<?= $form->field($model, 'answer_text')->textarea(['rows'=>7]) ?>				

				<div class="form-group">
					<?= Html::submitButton('Отправить', ['id'=>'zakaz-spec2-btn', 'class' => 'button-red']) ?>
				</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div><!-- profile-add-answer -->