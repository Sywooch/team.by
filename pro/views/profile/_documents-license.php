<div id="uploading-license" class="form-group clearfix pt-30">
	<div class="col-lg-4">
		<?= $form->field($model, 'license')->hiddenInput() ?>
	</div>
	<div class="col-lg-8">
		<?= $model->getLicenseLink($model->license) ?>
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

	<?/*
	<div class="row clearfix">
		<div class="col-lg-7">
			
			<p class="uploading-info">Отличное качество, форматы jpg, jpeg, png, gif, размер не менее 600х800px, до 5МБ</p>

			<div class="row clearfix">
				<div class="col-lg-7">
					<span id="upload-license-btn" class="button-red">Загрузить</span>
				</div>
				<div class="col-lg-5">
					<img id="loading-license" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
				</div>
				<div class="col-lg-12">
					<p id="loading-license-errormes" class="reg-step2-loading-errors"></p>
				</div>
			</div>
		</div>
		<div class="col-lg-5">
			<span id="license-cnt">
				<?php if($model->license) echo Html::a($model->license, Yii::$app->params['homeUrl']. '/' . Yii::$app->params['licenses-path'] . '/' .$model->license) ?>
			</span>
		</div>
	</div>
	*/?>
</div>		
