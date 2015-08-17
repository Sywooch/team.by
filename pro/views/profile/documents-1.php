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
	

//echo'<pre>';print_r($categories);echo'</pre>';
//echo'<pre>';print_r(Yii::$app->request->post());echo'</pre>';//die;

//$json_str = json_encode(Yii::$app->request->post()['ProfileAnketaForm ']);
//echo'<pre>';print_r(json_decode($json_str, 1));echo'</pre>';//die;
//echo'<pre>';print_r(($json_str));echo'</pre>';//die;
//echo'<pre>';print_r($model);echo'</pre>';//die;

$errors = $model->getErrors();
//echo'<pre>';print_r($errors);echo'</pre>';//die;



$categories_l2_arr = [];
?>
<div class="to_administration">
	<h1><?= $title?></h1>

		<?php $form = ActiveForm::begin([
			'options'=> ['enctype' => 'multipart/form-data' ],
			'id'=>'to-administration-frm',
		] ); ?>
		
		<div class="row clearfix">
			<div class="col-lg-6"><?= $form->field($model, 'passport_num') ?></div>
			<div class="col-lg-6"><?= $form->field($model, 'passport_vidan') ?></div>
		</div>
		
		<div class="row clearfix">
			<div class="col-lg-6"><?= $form->field($model, 'passport_expire') ?></div>
		</div>
		
		<div id="uploading-passport-file" class="form-group row clearfix  pt-30">
			<div class="col-lg-4">
				<?= $form->field($model, 'passport_file')->hiddenInput() ?>
			</div>
			<div class="col-lg-8">
				<?= Html::a($model->passport_file, (Yii::$app->params['homeUrl']. '/' .Yii::$app->params['documents-path'].'/'.$model->passport_file)?>
			</div>
			<div class="col-lg-4" style="clear:both;">
				<span id="upload-passport-file-btn" class="button-red">Загрузить</span>
			</div>

			<div class="col-lg-5">
				<p class="uploading-info">архив zip или rar объемом не более 10МБ</p>
			</div>

			<div class="col-lg-2">
				<img id="loading-passport-file" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
				<span id="loading-passport-file-success" class="reg-step2-loading-price-success">Загружено</span>
			</div>

			<p id="loading-passport-file-errormes" class="reg-step2-loading-errors col-lg-12 "></p>
		</div>		
		
		<div id="uploading-trud-book-file" class="form-group row clearfix  pt-30">
			<div class="col-lg-4">
				<?= $form->field($model, 'trud_file')->hiddenInput() ?>
			</div>
			<div class="col-lg-8">
				<?= Html::a($model->trud_file, (Yii::$app->params['homeUrl']. '/' .Yii::$app->params['documents-path'].'/'.$model->trud_file)?>
			</div>
			<div class="col-lg-4" style="clear:both;">
				<span id="upload-book-file-btn" class="button-red">Загрузить</span>
			</div>

			<div class="col-lg-5">
				<p class="uploading-info">архив zip или rar объемом не более 10МБ</p>
			</div>

			<div class="col-lg-2">
				<img id="loading-book-file" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
				<span id="loading-book-file-success" class="reg-step2-loading-price-success">Загружено</span>
			</div>

			<p id="loading-book-file-errormes" class="reg-step2-loading-errors col-lg-12"></p>
		</div>		
		
		<div id="uploading-diplom-file" class="form-group row clearfix  pt-30">
			<div class="col-lg-4">
				<?= $form->field($model, 'diplom_file')->hiddenInput() ?>
			</div>
			<div class="col-lg-8">
				<?= Html::a($model->diplom_file, (Yii::$app->params['homeUrl']. '/' .Yii::$app->params['documents-path'].'/'.$model->diplom_file)?>
			</div>
			<div class="col-lg-4" style="clear:both;">
				<span id="upload-diplom-file-btn" class="button-red">Загрузить</span>
			</div>

			<div class="col-lg-5">
				<p class="uploading-info">архив zip или rar объемом не более 10МБ</p>
			</div>

			<div class="col-lg-2">
				<img id="loading-diplom-file" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
				<span id="loading-diplom-file-success" class="reg-step2-loading-price-success">Загружено</span>
			</div>

			<p id="loading-diplom-file-errormes" class="reg-step2-loading-errors col-lg-12"></p>
		</div>	
		
				
		
		<?php echo $this->render('_documents_other', ['model'=>$model], false, true) ?>
		
		
		<div class="form-group">
			<?= Html::submitButton('Сохранить', ['class' => 'button-red']) ?>
		</div>
	<?php ActiveForm::end(); ?>
</div>