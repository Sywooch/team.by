<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use dosamigos\datepicker\DatePicker;

\frontend\assets\DatePickerRuAsset::register($this);	//русский язык подключаем
\backend\assets\ReviewFotoAsset::register($this);	//ajax загрузка фото

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="order-form">

    <?php $form = ActiveForm::begin(['options'=> ['enctype' => 'multipart/form-data' ],]); ?>

	<?php if($model->order_id != 0) { ?>
    	<?= $form->field($model, 'client_id')->dropDownList($model->clients, [$model->client_id, 'disabled'=>'disabled']) ?>
	<?php	}	else	{	?>
		<?= $form->field($model, 'client_id')->dropDownList($model->clients, [$model->client_id]) ?>
	<?php	}	?>
   
   <?php if($model->order_id == 0) { ?>
		<div id="add-new-client" class="row clearfix">
			<div class="col-lg-3"><?= $form->field($model, 'fio')->textInput() ?></div>
			<div class="col-lg-3"><?= $form->field($model, 'phone')->textInput() ?></div>
			<div class="col-lg-3"><?= $form->field($model, 'email')->textInput() ?></div>
			<div class="col-lg-3"><?= $form->field($model, 'info')->textInput() ?></div>
		</div>
    <?php	}	?>

    <?//= $form->field($model, 'category_id')->textInput() ?>
    <?= $form->field($model, 'category_id')->dropDownList($model->categories, [$model->category_id]) ?>
    
	<?= $form->field($model, 'descr')->textarea(['rows' => 6]) ?>
    
	<div class="row clearfix">
		<div class="col-lg-6"><?= $form->field($model, 'user_id')->dropDownList($model->users, [$model->user_id]) ?></div>
		<div class="col-lg-6">
			<?= $form->field($model, 'date_control')->widget(
				DatePicker::className(), [
					// inline too, not bad
					 //'inline' => true, 
					 // modify template for custom rendering
					//'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
					'clientOptions' => [
						'language'=> 'ru',
						'autoclose' => true,
						'format' => 'dd-M-yyyy'
					]
			]);?>    
		
		</div>
	</div>
	
		
	<div class="row clearfix">
		<div class="col-lg-4"><?= $form->field($model, 'price1')->textInput() ?></div>
		<div class="col-lg-4"><?= $form->field($model, 'price')->textInput() ?></div>
		<div class="col-lg-4"><?= $form->field($model, 'fee')->textInput() ?></div>
	</div>
    
    <div class="row clearfix">
    	<div class="col-lg-4"><?= $form->field($model, 'status')->dropDownList($model->statuses, [$model->status]) ?></div>
    	<div class="col-lg-4"><?= $form->field($model, 'payment_status')->dropDownList($model->paymentStatuses, [$model->payment_status]) ?></div>
    	<div class="col-lg-4"><?= $form->field($model, 'review_status')->dropDownList($model->reviewStatuses, [$model->review_status]) ?></div>
    </div>
    
    
    <?php if($model->order_id != 0 && $model->user_id > 0) { ?>
		<?= $form->field($model, 'review_text')->textarea(['rows' => 6]) ?>
		<?= $form->field($model, 'review_rating')->radioList($model->reviewRating, [$model->review_rating]) ?>


		<div id="uploading-review-foto" class="form-group clearfix">
			<label class="control-label" for="orderform-review_text">Фото отзыва</label>
			<div class="row clearfix">
				<div class="col-lg-4">
					<span id="upload-review-foto-btn" class="btn btn-info">Загрузить</span>
				</div>

				<div class="col-lg-2">
					<img id="loading-review-foto" class="loading-process" src="/images/loading.gif" alt="Loading" />
				</div>

				<div class="col-lg-5">
					<p id="loading-review-foto-errormes" class="loading-errors col-lg-12 "></p>
				</div>
			</div>

			<div id="uploading-review-foto-list" class="uploading-tmb-list">
				<ul class="clearfix">
					<?php for ($x=0; $x<=9; $x++) { ?>
						<li class="item-<?= ($x+1) ?> pull-left <?php echo (!isset($model->review_foto[$x])) ? 'no-foto' : '' ?>" data-item="<?= ($x+1) ?>">
							<?php 
								if(isset($model->review_foto[$x]))	{
									echo Html::a(Html::img(Yii::$app->urlManagerFrontEnd->baseUrl . '/'. Yii::$app->params['reviews-path'] . '/thumb_' .$model->review_foto[$x]), Yii::$app->urlManagerFrontEnd->baseUrl . '/'. Yii::$app->params['reviews-path'] . '/' .$model->review_foto[$x], ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'examplesimages']);
									echo Html::a('×', '#', ['class' => 'remove-uploaded-file', 'data-file'=>$model->review_foto[$x]]);
									echo Html::input('hidden', 'OrderForm[review_foto][]', $model->review_foto[$x]);
								}	else	{
									echo ($x+1);
								}	
							?>
						</li>
					<?php	}	?>
				</ul>
			</div>
		</div>
   <?php	}	?>
    
    
    
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
