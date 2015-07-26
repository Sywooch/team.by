<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>    

    <?//= $form->field($model, 'tree')->textInput() ?>

    <?//= $form->field($model, 'lft')->textInput() ?>

    <?//= $form->field($model, 'rgt')->textInput() ?>

    <?//= $form->field($model, 'depth')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
      
	<?= $form->field($model, 'parent_id')->dropDownList($categories, [$model->parent_id]) ?>   
	
    <?//= $form->field($model, 's_descr')->textInput(['maxlength' => true]) ?>	
	 
	<?//= $form->field($model, 'popular')->radioList([0=>'да', 1=>'нет'], ['class'=>'bs-switch']) ?> 
	<?//= $form->field($model, 'popular')->checkbox(['class'=>'bs-switch']) ?> 
	
	<?php 
	echo $form->field($model, 'description')->widget(CKEditor::className(), [
	  'editorOptions' => ElFinder::ckeditorOptions('elfinder',['preset' => 'full', 'inline' => false]),
	]); ?>	
    

    <? //= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_keyword')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_descr')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
