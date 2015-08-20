<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$title = 'Личные данные';
$this->title = \Yii::$app->params['sitename'] .' | ' . $title;


//print_r();
$UserTypesArray = Yii::$app->params['UserTypesArray']

?>
<div class="site-reg-step1 row clearfix">
	<div class="col-lg-7">
		<h1><?= Html::encode($title) ?></h1>
		
		<?php $form = ActiveForm::begin(); ?>

			<?//= $form->field($model, 'user_type')->radioList(Yii::$app->params['UserTypesArray'], [$model->user_type]) ?>
			<?= $form->field($model, 'user_type')->radioList($UserTypesArray, [$model->user_type]) ?>
			<?//= $form->field($model, 'user_type')->radioList([1 => 'Физическое лицо',2 => 'Юридическое лицо',3 => 'ИП',], [$model->user_type]) ?>
			

			<?= $form->field($model, 'fio') ?>
			
			<?= $form->field($model, 'email') ?>
			
			<?= $form->field($model, 'phone')->textInput(['class'=>'form-control phone-input']) ?>
			
			<?= $form->field($model, 'password')->passwordInput() ?>
			
			<?= $form->field($model, 'passwordRepeat')->passwordInput() ?>

			<div class="form-group">
				<?= Html::submitButton('Продолжить', ['class' => 'button-red']) ?>
			</div>
		<?php ActiveForm::end(); ?>
	</div>
	
	<div class="col-lg-4 col-lg-offset-1">
		<div class="reg_info">
			<div class="reg_info_ttl">
				Преимущества для специалистов team.by
			</div>
			<div class="reg_info_cnt">
				<p>За каждого полученного клиента вы платите нам указанную в заказе сумму <span>(от 5 до 15% от общей стоимости работы в зависимости от условий заказа)</span></p>
				<p><span>При этом вы</span>
				<br>
				• Платите за каждого клиента только один раз.Если данный клиент приходит к вам снова и снова, приводит друзей и знакомых - мы за вас только порадуемся. Этот заработок целиком и полностью ваш.
				<br><br>
				• Платите только за результат реальных клиентов, с которыми вы уже начали работать и от которых вы уже получили первые деньги.</p>
			</div>
		</div>
	</div>

</div><!-- site-reg-step1 -->
