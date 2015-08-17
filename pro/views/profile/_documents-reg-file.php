<div id="uploading-reg-file" class="form-group clearfix">
	<div class="col-lg-4">
		<?= $form->field($model, 'reg_file')->hiddenInput() ?>
	</div>
	<div class="col-lg-8">
		<?= $model->getFileLink($model->reg_file) ?>
	</div>
	<div class="col-lg-4" style="clear:both;">
		<span id="upload-reg-file-btn" class="button-red">Загрузить</span>
	</div>

	<div class="col-lg-5">
		<?php echo $this->render('_documents_files_note', [], false, true) ?>
	</div>

	<div class="col-lg-2">
		<img id="loading-reg-file" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
		<span id="loading-reg-file-success" class="reg-step2-loading-price-success">Загружено</span>
	</div>
</div>		
