<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="row clearfix">
	<?php $form = ActiveForm::begin(['action'=>['zakaz-spec1', 'modal'=>1]]); ?>
	<div class="col-lg-6">
		<?= $form->field($model, 'name')->textInput(['placeholder'=>'Введите ваше имя', 'class'=>'inputbox width100']) ?>
		<?/*<input type="text" class="inputbox width100" placeholder="Введите ваше имя">*/?>
	</div>
	<div class="col-lg-6">
		<?/*<input type="text" class="inputbox width100" placeholder="Введите ваш номер телефона">*/?>
		<?= $form->field($model, 'phone')->textInput(['placeholder'=>'Введите ваш номер телефона', 'class'=>'inputbox width100']) ?>
	</div>
	<div class="col-lg-6">
		<?/*<input type="text" class="inputbox width100" placeholder="Какого специалиста вы ищете">*/?>
		<?= $form->field($model, 'comment')->textInput(['placeholder'=>'Какого специалиста вы ищете', 'class'=>'inputbox width100']) ?>
	</div>
	<div class="col-lg-6">
		<?/*<input type="submit" class="button-red" value="Отправить заявку"> */?>
		<?= Html::submitButton('Отправить заявку', ['id'=>'send-zayavka', 'class' => 'button-red']) ?>
	</div>
	
	<?php ActiveForm::end(); ?>
</div>