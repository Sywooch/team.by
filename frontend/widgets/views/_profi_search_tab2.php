<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$countries_list = Yii::$app->params['countries'];

?>
<?php $form = ActiveForm::begin(['action'=>['zakaz-spec1', 'modal'=>1]]); ?>
	<div class="row clearfix">	
		<div class="col-lg-6">
			<?= $form->field($model, 'name')->textInput(['placeholder'=>'Ваше имя', 'class'=>'inputbox width100']) ?>
			<?//= $form->field($model, 'phone')->textInput(['placeholder'=>'Номер телефона +375 (XX)ХХХ-ХХ-ХХ', 'class'=>'inputbox width100 phone-input']) ?>
			
			<div id="country-flag-dropdown" class="country-flag-dropdown">
				<ul id="country-flag-list" class="country-flag-list">
					<?php
						foreach($countries_list as $key=>$country)
							echo Html::tag ( 'li', (Html::tag('span', ' ', ['class'=>'cflag18 cflag-'.mb_strtolower($key)]) . $country['name'] . ' ' . $country['phone_prefix']), ['data-cc'=>$key, 'data-prefix'=>$country['phone_prefix'] ] );
					?>
				</ul>
				<span id="cfd-value" class="cfd-value">
					<span id="cc-active" class="cflag18 cflag-<?= $model->country_code ?>"></span>
				</span>
			</div>
			
			<?= $form->field($model, 'phone')->textInput(['placeholder'=>'Номер телефона', 'class'=>'form-control phone-input phone-input-with-countries']) ?>
			<?= $form->field($model, 'country_code')->hiddenInput(['class'=>'country_code'])->label(false) ?>
		</div>
		<div class="col-lg-6">
			<?= $form->field($model, 'comment')->textarea(['placeholder'=>'Кого вы ищете? С чем надо помочь?', 'class'=>'inputbox width100', 'rows' => 3]) ?>
		</div>
	</div>
	<?= Html::submitButton('Отправить заявку', ['id'=>'send-zayavka', 'class' => 'button-red send-zayavka']) ?>
<?php ActiveForm::end(); ?>