<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use frontend\widgets\Alert;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

$this->title = 'Восстановление пароля';

?>
<style> .modal-body button{display:none;}</style>
<div class="modal-dialog modal-dialog__login site-request-password-reset modal-content">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h2 class="h2__modal"><?= Html::encode($this->title) ?></h2>
		</div>
		
		<div class="modal-body">
			<?= Alert::widget() ?>
		</div>
	</div>
</div>