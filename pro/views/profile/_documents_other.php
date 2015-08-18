<?php
use yii\helpers\Html;
?>

<div class="row clearfix mb-30">
	<div class="col-lg-7">
		<div id="uploading-other-file" class="form-group clearfix pt-30">
			<?php echo Html::input('hidden', $document_form.'[other_file][]', ''); ?>
			<div class="<?= isset($errors['other_file']) ? 'has-error' : '' ?>">
				<label class="reg-step2-uploading-ttl"><?php echo $model->getAttributeLabel('other_file'); ?></label>
				<?= isset($errors['other_file']) ? '<div class="help-block">'.$errors["other_file"][0].'</div>' : '' ?>
			</div>

			<?php echo $this->render('_documents_files_note', [], false, true) ?>

			<div class="row clearfix">
				<div class="col-lg-4">
					<span id="upload-other-file-btn" class="button-red">Загрузить</span>
				</div>

				<div class="col-lg-2">
					<img id="loading-other-file" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
					<span id="loading-other-file-success" class="reg-step2-loading-price-success">Загружено</span>
				</div>

				<div class="col-lg-5">
					<p id="loading-other-file-errormes" class="reg-step2-loading-errors col-lg-12"></p>
				</div>
			</div>

			<div id="uploading-other-file-list" class="uploading-other-file-list">
				<ul>
					<?php for ($x=0; $x<=9; $x++) { ?>
						<?php if(isset($model->other_file[$x]))	{ ?>
							<li>
								<?= $model->getLicenseLink($model->other_file[$x]) ?>
								<?= Html::input('hidden', $document_form.'[other_file][]', $model->other_file[$x]);?>
								<?php if($model->other_file[$x] != '') echo $this->render('_remove-document-file', ['data_file'=>'other_file'], false, true) ?>
							</li>
						<?php	}	?>
						<?/*
						<li class="item-<?= ($x+1) ?> pull-left <?php echo (!isset($model->other_file[$x])) ? 'no-foto' : '' ?>" data-item="<?= ($x+1) ?>">
							<?php 
								if(isset($model->other_file[$x]))	{
									echo Html::a(Html::img(Yii::$app->params['homeUrl']. '/' . Yii::$app->params['documents-path'] .'/thumb_' .$model->other_file[$x]), Yii::$app->params['homeUrl']. '/' . Yii::$app->params['documents-path'] .'/' .$model->other_file[$x], ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'other_file']);
									echo Html::a('×', '#', ['class' => 'remove-uploaded-file', 'data-file'=>$model->other_file[$x]]);
									echo Html::input('hidden', 'DocumentsForm1[other_file][]', $model->other_file[$x]);
								}	else	{
									echo ($x+1);
								}	
							?>
						</li>
						*/?>
					<?php	}	?>
				</ul>
			</div>
		</div>		
	</div>
</div>
