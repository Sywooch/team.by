<?php
use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ActiveForm;

?>
<div class="tab_pane_cnt">

		<?php $form = ActiveForm::begin([
			//'options'=> ['enctype' => 'multipart/form-data' ],
			'id'=>'documents-frm',
		] ); ?>
		
		<?php echo $this->render('_documents-reg-file', ['model'=>$model, 'form'=>$form, 'document_form' => $document_form], false, true) ?>
		
		<?php echo $this->render('_documents-license', ['model'=>$model, 'form'=>$form, 'document_form' => $document_form], false, true) ?>
			
		<?php echo $this->render('_documents-bitovie', ['model'=>$model, 'form'=>$form, 'document_form' => $document_form], false, true) ?>
		
		<?php echo $this->render('_documents_other', ['model'=>$model, 'form'=>$form, 'document_form' => $document_form], false, true) ?>
				
	<?php ActiveForm::end(); ?>
</div>