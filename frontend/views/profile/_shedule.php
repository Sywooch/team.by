<?php
use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ActiveForm;

use dosamigos\datepicker\DatePicker;

\frontend\assets\DatePickerRuAsset::register($this);
//use dosamigos\datepicker\DateRangePicker;

//echo'<pre>';var_dump($model->callHours);echo'</pre>';die;
?>

<div class="profile_shedule">
	<div class="row clearfix">
		<div class="col-lg-6 profile_shedule_weekends">
			<p class="profile_shedule_ttl">Мои выходные</p>

			<p>Работать с нами легко и удобно. Здесь вы можете настроить свое рабочее расписание. Если вы хотите избежать лишних звонков в отпуске или по праздникам - просто отметьте эти дни в календаре.</p>
				<div>
				<?= DatePicker::widget([
					'name' => 'Test',
					'value' => '02-16-2012',
					'template' => '{addon}{input}',
					'inline'=> true,
						'clientOptions' => [
							'language'=> 'ru',
							'autoclose' => false,
							'format' => 'dd-mm-yyyy',
							'multidate'=> true,
						]
				]);?>
					</div>
						
			<?php $form = ActiveForm::begin(['action'=>Url::to(['profile/set-weekend']), 'id'=>'set-weekend-frm']); ?>
			
				
				
				<?/*= $form->field($weekends, 'weekedns')->widget(
					DatePicker::className(), [
						// inline too, not bad
						//'inline' => true, 
						 // modify template for custom rendering
						//'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
						'template' => '{addon}{input}',
						'clientOptions' => [
							'language'=> 'ru',
							'autoclose' => false,
							'format' => 'dd-mm-yyyy',
							'multidate'=> true,
							
						]
				]);*/?>				
				<div class="form-group">
					<?= Html::submitButton('Сохранить', ['class' => 'button-red btn-short']) ?>
				</div>
			<?php ActiveForm::end(); ?>
			
			<p class="dinpro-b">Наши операторы всегда будут видеть, когда вы готовы работать</p>
		</div>
		<div class="col-lg-6 profile_shedule_call_time">
			<p class="profile_shedule_ttl">Удобное время для звонков</p>
			<div class="set-call-time-cnt">
				<?php $form = ActiveForm::begin(['action'=>Url::to(['profile/set-calltime']), 'id'=>'set-call-time-frm']); ?>
					<div class="row clearfix">
						<div class="col-lg-6"><?= $form->field($model, 'call_from')->dropDownList($model->callHours, [$model->call_from]) ?></div>
						<div class="col-lg-6"><?= $form->field($model, 'call_to')->dropDownList($model->callHours, [$model->call_to]) ?></div>
					</div>




					<div class="form-group">
						<?= Html::submitButton('Сохранить', ['class' => 'button-red btn-short']) ?>
					</div>

				<?php ActiveForm::end(); ?>
			</div>
			<p>Мы будем звонить вам только в удобное вам время.</p>

		</div>
	</div>
</div>