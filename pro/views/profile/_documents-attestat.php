<div class="row clearfix">
	<div class="col-lg-6">
		<div id="uploading-attestat-file" class="form-group row clearfix pt-30">
			<div class="col-lg-12">
				<?= $form->field($model, 'attestat_file')->hiddenInput() ?>
			</div>
			<div class="col-lg-12 mb-15">
				<?= $model->getFileLink($model->attestat_file) ?>
				<?php if($model->attestat_file != '') echo $this->render('_remove-document-file', ['data_file'=>'attestat_file'], false, true) ?>
			</div>
			<div class="col-lg-4" style="clear:both;">
				<span id="upload-attestat-file-btn" class="button-red">Загрузить</span>
			</div>

			<div class="col-lg-5">
				<?php echo $this->render('_documents_files_note', [], false, true) ?>
			</div>

			<div class="col-lg-2">
				<img id="loading-attestat-file" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
				<span id="loading-attestat-file-success" class="reg-step2-loading-price-success">Загружено</span>
			</div>

			<div class="col-lg-12">
				<p id="loading-attestat-file-errormes" class="reg-step2-loading-errors"></p>
			</div>
		</div>		
	</div>
</div>
