<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use frontend\models\RegStep2Form;
use backend\models\UserSearch;

use dosamigos\datepicker\DatePicker;

\frontend\assets\PhoneInputAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

///echo'<pre>';var_dump($allRoles);echo'</pre>';die;

if(count($model->regions)) {
	$regions_rows = count($model->regions) - 1;
}	else	{
	$regions_rows = 0;
}

?>

<div class="user-form tab_pane_cnt">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="hidden"><?= $form->field($model, 'username')->textInput() ?></div>
    
    <div class="row clearfix">
    	<div class="col-lg-4"><?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'class'=>'form-control phone-input']) ?></div>
    	<div class="col-lg-4"><?= $form->field($model, 'email')->textInput() ?></div>
    	<div class="col-lg-2"><?= $form->field($model, 'user_status')->dropDownList($model->userStatuses, [$model->user_status]) ?></div>
    	<div class="col-lg-2"><?= $form->field($model, 'black_list')->dropDownList([0=>'Нет',1=>'Да'], [$model->user_status]) ?></div>
    </div>

    <div class="row clearfix">
    	<div class="col-lg-3"><?= $form->field($model, 'fio')->textInput() ?></div>
    	<div class="col-lg-3"><?= $form->field($model, 'user_type')->dropDownList(Yii::$app->params['UserTypesArray'], [$model->user_type]) ?></div>
    	
    	<div class="col-lg-3"><?= $form->field($model, 'categoryUser')->dropDownList(UserSearch::getDropdownCatList(), [$model->categoryUser, 'readonly'=>'readonly']) ?></div>
		<div class="col-lg-3"><?= $form->field($model, 'is_active')->dropDownList($model->userActivityList, [$model->is_active, 'readonly'=>'readonly']) ?></div>    	
    </div>
    
	<div id="regions-wr" class="row clearfix">
		<div id="regions-cnt" class="regions-cnt col-lg-6">
			<div class="row clearfix">
				<div class="col-lg-8 region-dd-cnt"><label class="control-label">Город</label></div>
				<div class="col-lg-3"><label class="control-label">Коэфициент</label></div>
			</div>
				
			<?php for ($x=0; $x<=$regions_rows; $x++) { ?>
				<div <? if ($x==0) echo 'id="region-row-f"' ?> class="form-group row clearfix region-row">
					<div class="col-lg-8 region-dd-cnt">
						<?//= Html::activeDropDownList($model, 'regions[]', $model->regionsDropDownList, ['class'=>'form-control']) ?>
						<?= Html::dropDownList('ProfileAnketaForm[regions][]', $model->regions[$x], RegStep2Form::getRegionsDropDownList(), ['class'=>'form-control', 'disabled'=>'disabled']) ?>
					</div>
					<div class="col-lg-3">
						<?//= Html::activeTextInput($model, 'ratios[]', ['placeholder'=>'коэффициент', 'class'=>'form-control']) ?>
						<?= Html::textInput('ProfileAnketaForm[ratios][]', $model->ratios[$x], ['placeholder'=>'коэффициент', 'class'=>'form-control', 'disabled'=>'disabled']) ?>
					</div>
					<?/*
					<div class="col-lg-1">
						<a href="#" class="remove_region_row">—</a>
					</div>
					*/?>
				</div>
			<?php	}	?>
		</div>
		<?/*
		<div class="form-group">
			<a href="#" class="add_new_region">Добавить</a>
		</div>
		*/?>

	</div>
    

	<div class="row clearfix">
    	<div class="col-lg-6"><?= $form->field($model, 'about')->textarea(['rows'=>5]) ?></div>
    	<div class="col-lg-6"><?= $form->field($model, 'education')->textarea(['rows'=>5]) ?></div>
    </div>

	<div class="row clearfix">
    	<div class="col-lg-6"><?= $form->field($model, 'experience')->textarea(['rows'=>5]) ?></div>
    	
		<?php if($model->call_time_from > 0 || $model->call_time_to > 0) { ?>
		<div class="col-lg-3 form-group">
			<label class="control-label">Время для звонков</label>
			<div>
				<?php if($model->call_time_from > 0)  echo 'c '.$model->call_time_from . ':00'?>
				<?php if($model->call_time_to > 0)  echo 'до '.$model->call_time_to . ':00'?>
			</div>
		</div>
		<?php	}	?>
	
		<?php if(count($model->userWeekend)) { ?>
			<div class="col-lg-3 form-group">
				<label class="control-label">Выходные дни</label>
				<?php foreach($model->userWeekend as $row ) { ?>
					<p><?= Yii::$app->formatter->asDate($row->weekend, 'php:d-m-yy')?></p>
				<?php	}	?>
			</div>
		<?php	}	?>
    	
    </div>
	
	<?/*
	<div class="row clearfix">
    	<div class="col-lg-6"><?= $form->field($model, 'to_client')->checkbox() ?></div>
    	<div class="col-lg-6"><?= $form->field($model, 'specialization') ?></div>
    </div>
	*/?>
    
    <?/*
	<div id="uploading-awards-list" class="uploading-tmb-list">
		<ul>
			<?php for ($x=0; $x<=9; $x++) { ?>
				<li class="item-<?= ($x+1) ?> pull-left <?php echo (!isset($model->media['awards'][$x])) ? 'no-foto' : '' ?>" data-item="<?= ($x+1) ?>">
					<?php 
						if(isset($model->media['awards'][$x]))	{
							echo Html::a(Html::img(Url::home(true) . 'tmp/thumb_' .$model->media['awards'][$x]), Url::home(true) . 'tmp/' .$model->media['awards'][$x], ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'awardsimages']);
							echo Html::a('×', '#', ['class' => 'remove-uploaded-file', 'data-file'=>$model->media['awards'][$x]]);
							echo Html::input('hidden', 'RegStep2Form[awards][]', $model->media['awards'][$x]);
						}	else	{
							echo ($x+1);
						}	
					?>
				</li>
			<?php	}	?>
		</ul>
	</div>
	*/?>
   
	<?php	if($model->license != '' || $model->license != 0) { ?>
		<div class="row clearfix">
			<div class="col-lg-6 form-group"><?= Html::a(Html::img(Yii::$app->urlManagerFrontEnd->baseUrl . '/'. Yii::$app->params['licenses-path'] . '/thumb_' .$model->license), Yii::$app->urlManagerFrontEnd->baseUrl . '/'. Yii::$app->params['licenses-path'] . '/' .$model->license, ['data-toggle' => 'lightbox', 'data-gallery'=>'license-images']);?></div>
			<div class="col-lg-6">
				<?= $form->field($model, 'license_checked')->widget(
					DatePicker::className(), [
						'clientOptions' => [
							'language'=> 'ru',
							'autoclose' => true,
							'format' => 'dd-mm-yyyy'
						]
				]);?>    

			</div>
		</div>
	<?php	}	?>


    
    
    
    
    <?php //if($model->isNewRecord) echo $form->field($model, 'password')->textInput() ?>
       
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php //if(!$model->isNewRecord) echo Html::a(Yii::t('app', 'Изменить пароль'), ['change-password', 'id'=>$model->id ], ['class' => 'btn btn-primary']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
