<?php if($model->reg_file != '')	{	?>
	<div class="row clearfix">
		<div class="col-lg-6 form-group">
			<div id="uploading-reg-file" class="row form-group clearfix">
				<div class="col-lg-12">
					<label><?php echo $model->getAttributeLabel('reg_file'); ?></label>
				</div>
				<div class="col-lg-12 mb-15 doc-file-cnt">
					<?= $model->getFileLink($model->reg_file) ?>
				</div>
			</div>		
		</div>
	</div>
<?php	}	?>
