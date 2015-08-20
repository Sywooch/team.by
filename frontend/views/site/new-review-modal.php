<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\widgets\Alert;

/* @var $this yii\web\View */
/* @var $model frontend\models\AddReviewForm */
/* @var $form ActiveForm */

$this->title = 'Новый отзыв';

//echo'<pre>';print_r($model->foto);echo'</pre>';//die;

?>






<div class="modal-dialog modal-dialog__zakaz-spec1 modal-content">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h2 class="h2__modal"><?= Html::encode($this->title) ?></h2>
		</div>
		
		<div class="modal-body">
			<?= Alert::widget() ?>
			<?php $form = ActiveForm::begin(); ?>

				<?//= $form->field($model, 'user_id') ?>

				<?= $form->field($model, 'phone')->textInput(['class'=>'inputbox width100 phone-input']) ?>
				<?= $form->field($model, 'name') ?>
				<?= $form->field($model, 'user_id')->dropDownList($model->userList, [$model->user_id]) ?>
				<div id="speclist-cnt" class="form-group"></div>
				<?= $form->field($model, 'comment')->textarea(['col'=>3]) ?>
				<?= $form->field($model, 'rating')->radioList($model->reviewRating, [$model->rating]) ?>
				<?//= $form->field($model, 'foto') ?>
				
				<div id="uploading-reviewfoto" class="form-group clearfix">
					<div>
						<label class="reg-step2-uploading-ttl"><?php echo $model->getAttributeLabel('foto'); ?></label>
					</div>					

					<div class="row clearfix">
						<div class="col-lg-4">
							<span id="upload-reviewfoto-btn" class="button-red">Загрузить</span>
						</div>

						<div class="col-lg-2">
							<img id="loading-reviewfoto" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
						</div>

						<div class="col-lg-5">
							<p id="loading-reviewfoto-errormes" class="reg-step2-loading-errors col-lg-12 "></p>
						</div>
					</div>

					<div id="uploading-reviewfoto-list" class="uploading-tmb-list">
						<ul>
							<?php for ($x=0; $x<=4; $x++) { ?>
								<li class="item-<?= ($x+1) ?> pull-left <?php echo (!isset($model->foto[$x])) ? 'no-foto' : '' ?>" data-item="<?= ($x+1) ?>">
									<?php
										if(isset($model->foto[$x]))	{
											echo Html::a(Html::img(Url::home(true) . 'tmp/thumb_' .$model->foto[$x]), Url::home(true) . 'tmp/' .$model->foto[$x], ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'examplesimages']);
											//echo Html::a('×', '#', ['class' => 'remove-uploaded-file', 'data-file'=>$model->foto[$x]]);
											echo Html::input('hidden', 'AddReviewForm[foto][]', $model->foto[$x]);
										}	else	{
											echo ($x+1);
										}	
									?>
									
								</li>
							<?php	}	?>
						</ul>
					</div>
				</div>	
				
				<?= $form->field($model, 'video') ?>	
				

				<div class="form-group">
					<?= Html::submitButton('Отправить', ['id'=>'send-new-review', 'class' => 'button-red']) ?>
				</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>