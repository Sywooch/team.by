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
		<h2 class="mb-20">Контактное лицо</h2>
		<div class="row clearfix">
			<div class="col-lg-6"><?= $form->field($model, 'contact_fio') ?></div>
			<div class="col-lg-6"><?= $form->field($model, 'contact_phone') ?></div>
		</div>
		
		<div class="row clearfix">
			<div class="col-lg-6" style="margin-top:22px;"><?= $form->field($model, 'contact_dolj') ?></div>
			<div class="col-lg-6"><?= $form->field($model, 'contact_osn') ?></div>
		</div>
		
		
		<?php echo $this->render('_documents-reg-file', ['model'=>$model, 'form'=>$form], false, true) ?>
		
		<?php echo $this->render('_documents-license', ['model'=>$model, 'form'=>$form], false, true) ?>
		
		<?php echo $this->render('_documents-bitovie', ['model'=>$model, 'form'=>$form], false, true) ?>
		
		<?php echo $this->render('_documents-attestat', ['model'=>$model, 'form'=>$form], false, true) ?>
		
		
		<?php //echo $this->render('_documents_other', ['model'=>$model], false, true) ?>
		
		

		<div class="form-group mt-30">
			<?= Html::submitButton('Сохранить', ['class' => 'button-red']) ?>
		</div>
	<?php ActiveForm::end(); ?>
</div>