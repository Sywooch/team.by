<div class="row clearfix">
	<div class="col-lg-6">
		<div id="uploading-bitovie-file" class="form-group row clearfix pt-30">
			<div class="col-lg-12">
				<?= $form->field($model, 'bitovie_file')->hiddenInput() ?>
			</div>
			<div class="col-lg-12 mb-15">
				<?= $model->getFileLink($model->bitovie_file) ?>
				<?php if($model->bitovie_file != '') echo $this->render('_remove-document-file', ['data_file'=>'bitovie_file'], false, true) ?>
			</div>
			<div class="col-lg-4" style="clear:both;">
				<span id="upload-bitovie-file-btn" class="button-red">Загрузить</span>
			</div>

			<div class="col-lg-5">
				<?php echo $this->render('_documents_files_note', [], false, true) ?>
			</div>

			<div class="col-lg-2">
				<img id="loading-bitovie-file" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
				<span id="loading-bitovie-file-success" class="reg-step2-loading-price-success">Загружено</span>
			</div>

			<div class="col-lg-12">
				<p id="loading-bitovie-file-errormes" class="reg-step2-loading-errors"></p>
			</div>
		</div>		
	</div>
</div>
