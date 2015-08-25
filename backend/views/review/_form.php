<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

\backend\assets\ReviewFotoAsset::register($this);	//ajax загрузка фото
\backend\assets\BootstrapLightboxAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\Review */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="review-form">

    <?php $form = ActiveForm::begin(); ?>
	<div class="row clearfix">
		<div class="col-lg-3"><?= $form->field($model, 'order_id')->dropDownList($model->orders, [$model->order_id]) ?></div>
		<div class="col-lg-3"><?= $form->field($model, 'client_id')->dropDownList($model->clients, [$model->client_id]) ?></div>
		<div class="col-lg-3"><?= $form->field($model, 'user_id')->dropDownList($model->users, [$model->user_id]) ?></div>
		
	</div>
    
    <div class="row clearfix">
    	<div class="col-lg-3"><?= $form->field($model, 'review_rating')->dropDownList($model->ratingList, [$model->review_rating]) ?></div>
    	<div class="col-lg-3"><?= $form->field($model, 'status')->dropDownList($model->reviewStates, [$model->status]) ?></div>
	</div>
    

    <?= $form->field($model, 'review_text')->textarea(['rows' => 10]) ?>

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
				<?php for ($x=0; $x<=4; $x++) { ?>
					<li class="item-<?= ($x+1) ?> pull-left <?php echo (!isset($model->review_foto[$x])) ? 'no-foto' : '' ?>" data-item="<?= ($x+1) ?>">
						<?php 
							if(isset($model->review_foto[$x]))	{
								echo Html::a(Html::img(Yii::$app->urlManagerFrontEnd->baseUrl . '/'. Yii::$app->params['reviews-path'] . '/thumb_' .$model->review_foto[$x]), Yii::$app->urlManagerFrontEnd->baseUrl . '/'. Yii::$app->params['reviews-path'] . '/' .$model->review_foto[$x], ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'examplesimages']);
								echo Html::a('×', '#', ['class' => 'remove-uploaded-file', 'data-file'=>$model->review_foto[$x]]);
								echo Html::input('hidden', 'Review[review_foto][]', $model->review_foto[$x]);
							}	else	{
								echo ($x+1);
							}	
						?>
					</li>
				<?php	}	?>
			</ul>
		</div>
	</div>
	
	<?= $form->field($model, 'youtube')->textInput() ?>
 	
  	<?php if($model->youtube != '')	{	?>
		<div class="form-group clearfix">
			<div class="mb-30">
				<?php echo \common\helpers\DYoutubeHelper::getYoutubeBlock($model->youtube) ?>
			</div>
		</div>
	<?php	}	?>
	
	<h2>Ответ специалиста</h2>

	<?= $form->field($model, 'answer_text')->textarea(['rows' => 6]) ?>
	
	<?= $form->field($model, 'answer_status')->dropDownList($model->answerStatuses, [$model->answer_status]) ?>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
