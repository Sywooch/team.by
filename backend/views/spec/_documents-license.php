<?php if($model->reg_file != '')	{	?>
<div class="row clearfix">
	<div class="col-lg-6 form-group">
		<div id="uploading-license" class="row form-group clearfix pt-30">
			<div class="col-lg-12">
				<label><?php echo $model->getAttributeLabel('license'); ?></label>
			</div>
			<div class="col-lg-12 mb-15">
				<?= $model->getLicenseLink($model->license) ?>
			</div>
		</div>		
	</div>
</div>
<?php	}	?>