<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use frontend\assets\RegAsset;

RegAsset::register($this);

/* @var $this yii\web\View */
/* @var $model frontend\models\RegStep1Form */
/* @var $form ActiveForm */

$this->title = 'Личные данные';
?>
<div class="site-reg-step1">
	<div class="col-lg-7">
		<h1><?= Html::encode($this->title) ?></h1>
		
		<?php $form = ActiveForm::begin(); ?>

			<?= $form->field($model, 'user_type')->radioList(Yii::$app->params['UserTypesArray'], [$model->user_type]) ?>

			<?= $form->field($model, 'fio') ?>
			
			<?= $form->field($model, 'email') ?>
			
			<?= $form->field($model, 'phone') ?>
			
			<?= $form->field($model, 'password') ?>
			
			<?= $form->field($model, 'passwordRepeat') ?>

			<div class="form-group">
				<?= Html::submitButton('Продолжить', ['class' => 'button-red']) ?>
			</div>
		<?php ActiveForm::end(); ?>
	</div>
	<div class="col-lg-5"></div>

</div><!-- site-reg-step1 -->
