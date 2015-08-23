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

			<div id="uploading-other-file-list" class="uploading-other-file-list">
				<ul>
					<?php for ($x=0; $x<=9; $x++) { ?>
						<?php if(isset($model->other_file[$x]))	{ ?>
							<li class="form-group">
								<?= $model->getFileLink($model->other_file[$x]) ?>
								<?= Html::input('hidden', $document_form.'[other_file][]', $model->other_file[$x]);?>
							</li>
						<?php	}	?>
					<?php	}	?>
				</ul>
			</div>
		</div>		
	</div>
</div>
