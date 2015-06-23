<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
$this->title = 'Вход в личный кабинет';

?>

<div class="modal-dialog modal-dialog__login modal-content">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h2 class="h2__modal"><?= Html::encode($this->title) ?></h2>
		</div>
		
		<div class="modal-body">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?//= $form->field($model, 'rememberMe')->checkbox() ?>
                <?/*
                <div style="color:#999;margin:1em 0">
                    If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                </div>
				*/?>
                <div class="form-group clearfix">
                    <?= Html::submitButton('Войти', ['class' => 'button-red login_button', 'name' => 'login-button']) ?>
                    <?= Html::a('Забыли пароль?', ['site/request-password-reset'], ['class' => 'reset_url']) ?>
                    <?= Html::a('Регистрация', ['site/signup'], ['class' => 'signup_url']) ?>
                </div>
            <?php ActiveForm::end(); ?>
		</div>

	</div>
</div>