<div class="row clearfix">
	<div class="col-lg-6">

		<div id="uploading-license" class="row form-group clearfix pt-30">
			<div class="col-lg-12">
				<?= $form->field($model, 'license')->hiddenInput() ?>
			</div>
			<div class="col-lg-12 mb-15">
				<?= $model->getLicenseLink($model->license) ?>
				<?php if($model->license != '') echo $this->render('_remove-document-file', ['data_file'=>'license'], false, true) ?>
			</div>
			<div class="col-lg-4" style="clear:both;">
				<span id="upload-license-btn" class="button-red">Загрузить</span>
			</div>

			<div class="col-lg-5">
				<?php echo $this->render('_documents_files_note', [], false, true) ?>
			</div>

			<div class="col-lg-2">
				<img id="loading-license" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
				<span id="loading-license-success" class="reg-step2-loading-price-success">Загружено</span>
			</div>

			<p id="loading-license-errormes" class="reg-step2-loading-errors col-lg-12" style="clear:both;"></p>
		</div>		
	</div>

</div>
