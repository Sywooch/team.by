

<div class="tab_pane_cnt">
	<?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'meta_keyword')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'meta_descr')->textarea(['rows'=>5]) ?>
</div>
