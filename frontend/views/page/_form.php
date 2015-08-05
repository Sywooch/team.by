<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;

use yii\helpers\Html;
use yii\widgets\ActiveForm;






/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $form yii\widgets\ActiveForm */

//echo'<pre>';print_r($_SERVER);echo'</pre>';
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
    
	<?php 
	echo $form->field($model, 'text')->widget(CKEditor::className(), [
	  'editorOptions' => ElFinder::ckeditorOptions('elfinder',['preset' => 'full', 'inline' => false]),
	]);	
	/*
	echo $form->field($model, 'text')->widget(CKEditor::className(),[
		'editorOptions' => [
			['elfinder', 'path' => 'some/sub/path'],
			'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
			'inline' => false, //по умолчанию false
		],
	]); 
	*/
	?> 

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
