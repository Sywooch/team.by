<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use frontend\widgets\Alert;

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
			<?= Alert::widget() ?>
		</div>
	</div>
</div><!-- profile-add-answer -->