<div class="row clearfix">
	<div class="col-lg-6">
		<div id="uploading-reg-file" class="row form-group clearfix">
			<div class="col-lg-12">
				<?= $form->field($model, 'reg_file')->hiddenInput() ?>
			</div>
			<div class="col-lg-12 mb-15 doc-file-cnt">
				<?= $model->getFileLink($model->reg_file) ?>
				<?php if($model->reg_file != '') echo $this->render('_remove-document-file', ['data_file'=>'reg_file'], false, true) ?>
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

			<p id="loading-reg-file-errormes" class="reg-step2-loading-errors col-lg-12" style="clear:both;"></p>
		</div>		
	</div>
</div>
