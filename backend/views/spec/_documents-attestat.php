<?php if($model->reg_file != '')	{	?>
<div class="row clearfix">
	<div class="col-lg-6 form-group">
		<div id="uploading-attestat-file" class="form-group row clearfix pt-30">
			<div class="col-lg-12">
				<label><?php echo $model->getAttributeLabel('attestat_file'); ?></label>
			</div>
			<div class="col-lg-12 mb-15">
				<?= $model->getFileLink($model->attestat_file) ?>
			</div>
		</div>		
	</div>
</div>
<?php	}	?>
