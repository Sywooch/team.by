<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;

?>

<div class="tab_pane_cnt">
	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
    
    <?php if($model->id != 12)  {   ?>
	<?php echo $form->field($model, 'text')->widget(CKEditor::className(), [
		'editorOptions' => ElFinder::ckeditorOptions('elfinder',['preset' => 'full', 'inline' => false]),
	]);	?> 
	<?php  }   else    {   ?>
	    <?= $form->field($model, 'text')->textarea(['rows'=>5]) ?>
	<?php  }   ?>

</div>
