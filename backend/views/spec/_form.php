<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use frontend\models\RegStep2Form;
use backend\models\UserSearch;

use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

///echo'<pre>';var_dump($allRoles);echo'</pre>';die;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row clearfix">
    	<div class="col-lg-4"><?= $form->field($model, 'username')->textInput() ?></div>
    	<div class="col-lg-4"><?= $form->field($model, 'email')->textInput() ?></div>
    	<div class="col-lg-4"><?= $form->field($model, 'user_status')->dropDownList($model->userStatuses, [$model->user_status]) ?></div>
    </div>

    <div class="row clearfix">
    	<div class="col-lg-3"><?= $form->field($model, 'fio')->textInput() ?></div>
    	<div class="col-lg-3"><?= $form->field($model, 'user_type')->dropDownList(Yii::$app->params['UserTypesArray'], [$model->user_type]) ?></div>
    	<div class="col-lg-3"><?= $form->field($model, 'region_id')->dropDownList(RegStep2Form::getRegionsDropDownList(), [$model->region_id]) ?></div>
    	<div class="col-lg-3"><?= $form->field($model, 'categoryUser')->dropDownList(UserSearch::getDropdownCatList(), [$model->categoryUser]) ?></div>
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
