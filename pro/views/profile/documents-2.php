<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\ProfileAnketaForm  */
/* @var $form ActiveForm */

use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ActiveForm;

\pro\assets\DocumentsAsset::register($this);
\pro\assets\BootstrapLightboxAsset::register($this);
\pro\assets\FormStylerAsset::register($this);

$title = 'Документы';
$this->title = \Yii::$app->params['sitename'] .' | ' . $title;

$this->params['breadcrumbs'] = [
	['label' => 'Личный кабинет', 'url' => '/profile'],
	['label' => $title]
];
	
$errors = $model->getErrors();
?>
<div class="to_administration">
	<h1><?= $title?></h1>

		<?php $form = ActiveForm::begin([
			//'options'=> ['enctype' => 'multipart/form-data' ],
			'id'=>'documents-frm',
		] ); ?>
		
		<div class="row clearfix">
			<div class="col-lg-6">
				<?php echo $this->render('_documents-reg-file', ['model'=>$model, 'form'=>$form], false, true) ?>
			</div>
			
		</div>
		
		
		
		<div class="row clearfix">
			<div class="col-lg-6">
				<?php echo $this->render('_documents-license', ['model'=>$model, 'form'=>$form], false, true) ?>
			</div>
			
		</div>
		
		<div class="row clearfix">
			<div class="col-lg-6">
				<div id="uploading-bitovie-file" class="form-group clearfix pt-30">
					<div class="row clearfix">
						<div class="col-lg-7">
							<?= $form->field($model, 'bitovie_file')->hiddenInput() ?>
							<p class="uploading-info">Отличное качество, форматы jpg, jpeg, png, gif, размер не менее 600х800px, до 5МБ</p>

							<div class="row clearfix">
								<div class="col-lg-7">
									<span id="upload-bitovie-file-btn" class="button-red">Загрузить</span>
								</div>
								<div class="col-lg-5">
									<img id="loading-bitovie-file" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
								</div>
								<div class="col-lg-12">
									<p id="loading-bitovie-file-errormes" class="reg-step2-loading-errors"></p>
								</div>
							</div>
						</div>
						<div class="col-lg-5">
							<span id="bitovie-file-cnt">
								<?php if($model->bitovie_file) echo Html::a(Html::img(Yii::$app->params['homeUrl']. '/' . Yii::$app->params['documents-path'] . '/thumb_' .$model->bitovie_file, ['class'=>'img-responsive']), Yii::$app->params['homeUrl']. '/' . Yii::$app->params['documents-path'] . '/' .$model->bitovie_file, ['class' => '', 'data-toggle' => 'lightbox']) ?>
							</span>
						</div>
					</div>
				</div>		
		
			</div>
			
		</div>
		
		
		<?php //echo $this->render('_documents_other', ['model'=>$model], false, true) ?>
		
		
		<div class="form-group">
			<?= Html::submitButton('Сохранить', ['class' => 'button-red']) ?>
		</div>
	<?php ActiveForm::end(); ?>
</div>