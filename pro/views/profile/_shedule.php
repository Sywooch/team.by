<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

use yii\widgets\ActiveForm;

use dosamigos\datepicker\DatePicker;

\frontend\assets\DatePickerRuAsset::register($this);
//use dosamigos\datepicker\DateRangePicker;

//echo'<pre>';var_dump($model->callHours);echo'</pre>';die;
$js = "
if($('#setweekendform-weekends').val() != '') {
	var weekend_arr = $('#setweekendform-weekends').val().split(';');
	$('#weekend-input').parent().datepicker('setDates', weekend_arr);
}

";

$this->registerJs($js, View::POS_LOAD, 'shedule');
?>

<div class="profile_shedule">
	<div class="row clearfix">
		<div class="col-lg-6 profile_shedule_weekends">
			<p class="profile_shedule_ttl">Мои выходные</p>

			
				<div>
					<?= DatePicker::widget([
						'name' => 'Test',
						'id' => 'weekend-input',
						//'value' => '02-16-2012',
						'template' => '{addon}{input}',
						'inline'=> true,
							'clientOptions' => [
								'language'=> 'ru',
								'autoclose' => false,
								'format' => 'dd-mm-yyyy',
								'multidate'=> true,
								'enableOnReadonly' => true,
							]
					]);?>
				</div>
						
				<?php $form = ActiveForm::begin([
					'action'=>Url::to(['profile/set-weekend']), 
					'id'=>'set-weekend-frm',
					'enableClientValidation' => false,
				]); ?>
			
				<?= $form->field($weekends, 'weekends')->hiddenInput();?>
				
				<div class="form-group">
					<?= Html::submitButton('Сохранить', ['class' => 'button-red btn-short']) ?>
				</div>
			<?php ActiveForm::end(); ?>
			
			<p class="mb-20">Работать с нами легко и удобно. Здесь вы можете настроить свое рабочее расписание. Если вы хотите избежать лишних звонков в отпуске или по праздникам - просто отметьте эти дни в календаре.</p>			
			
			<p class="dinpro-b">Наши операторы всегда будут видеть, когда вы готовы работать</p>
		</div>
		<div class="col-lg-6 profile_shedule_call_time">
			<p class="profile_shedule_ttl">Удобное время для звонков</p>
			<?php $form = ActiveForm::begin(['action'=>Url::to(['profile/set-calltime']), 'id'=>'set-call-time-frm']); ?>
				<div class="set-call-time-cnt">
					<div class="row clearfix">
						<div class="col-lg-6"><?= $form->field($model, 'call_from')->dropDownList($model->callHours, [$model->call_from]) ?></div>
						<div class="col-lg-6"><?= $form->field($model, 'call_to')->dropDownList($model->callHours, [$model->call_to]) ?></div>
					</div>
				</div>
				
				<div class="form-group">
					<?= Html::submitButton('Сохранить', ['class' => 'button-red btn-short']) ?>
				</div>

				<div id="profile-time-error-cnt" class="has-error">
					<div id="profile-time-error" class="help-block">Укажите правильно удобное время для звонков.</div>
				</div>

				<p>Мы будем звонить вам только в удобное вам время.</p>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>