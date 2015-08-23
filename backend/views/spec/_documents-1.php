<?php
use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ActiveForm;

\pro\assets\DocumentsAsset::register($this);
\pro\assets\BootstrapLightboxAsset::register($this);
\pro\assets\FormStylerAsset::register($this);

?>
<div class="tab_pane_cnt">

		<?php $form = ActiveForm::begin([
			'options'=> ['enctype' => 'multipart/form-data' ],
			'id'=>'to-administration-frm',
		] ); ?>
		
		<div class="row clearfix">
			<div class="col-lg-4"><?= $form->field($model, 'passport_num') ?></div>
			<div class="col-lg-4"><?= $form->field($model, 'passport_vidan') ?></div>
			<div class="col-lg-4"><?= $form->field($model, 'passport_expire') ?></div>
		</div>
		
		<?php if($model->passport_file != '')	{	?>
		<div class="row clearfix">
			<div class="col-lg-6 form-group">
				<div id="uploading-passport-file" class="form-group row clearfix  pt-30">
					<div class="col-lg-12">
						<label><?php echo $model->getAttributeLabel('passport_file'); ?></label>
					</div>
					<div class="col-lg-12 mb-15 doc-file-cnt">
						<?= $model->getFileLink($model->passport_file) ?>
					</div>
				</div>		
			</div>		
		</div>
		<?php	}	?>

		<?php if($model->trud_file != '')	{	?>
		<div class="row clearfix">
			<div class="col-lg-6 form-group">		
				<div id="uploading-trud-book-file" class="form-group row clearfix  pt-30">
					<div class="col-lg-12">
						<label><?php echo $model->getAttributeLabel('trud_file'); ?></label>
					</div>
					
					<div class="col-lg-12 mb-15 doc-file-cnt">
						<?= $model->getFileLink($model->trud_file) ?>
					</div>
				</div>		
			</div>		
		</div>
		<?php	}	?>
		
		<?php if($model->diplom_file != '')	{	?>
		<div class="row clearfix">
			<div class="col-lg-6 form-group">						
				<div id="uploading-diplom-file" class="form-group row clearfix  pt-30">
					<div class="col-lg-12">
						<label><?php echo $model->getAttributeLabel('diplom_file'); ?></label>
					</div>
					<div class="col-lg-12 mb-15 doc-file-cnt">
						<?= $model->getFileLink($model->diplom_file) ?>
					</div>
				</div>
			</div>
		</div>
		<?php	}	?>
		
		<?php echo $this->render('_documents_other', ['model'=>$model,'document_form' => $document_form], false, true) ?>
				
	<?php ActiveForm::end(); ?>
</div>