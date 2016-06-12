<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\ProfileAnketaForm  */
/* @var $form ActiveForm */

use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ActiveForm;

//echo'<pre>';print_r($model);echo'</pre>';//return;//die;
//echo'<pre>';print_r($document_form);echo'</pre>';//return;//die;

?>
<div class="tab_pane_cnt">

		<?php $form = ActiveForm::begin([
			//'options'=> ['enctype' => 'multipart/form-data' ],
			'id'=>'documents-frm',
		] ); ?>
		<h2 class="mb-20">Контактное лицо</h2>
		<div class="row clearfix">
			<div class="col-lg-6"><?= $form->field($document_form, 'contact_fio') ?></div>
			<div class="col-lg-6"><?= $form->field($document_form, 'contact_phone') ?></div>
		</div>
		
		<div class="row clearfix">
			<div class="col-lg-6" style="margin-top:22px;"><?= $form->field($document_form, 'contact_dolj') ?></div>
			<div class="col-lg-6"><?= $form->field($document_form, 'contact_osn') ?></div>
		</div>
		
		
		<?php echo $this->render('_documents-reg-file', ['model'=>$model, 'form'=>$form, 'document_form' => $document_form], false, true) ?>
		
		<?php echo $this->render('_documents-license', ['model'=>$model, 'form'=>$form, 'document_form' => $document_form], false, true) ?>
		
		<?php echo $this->render('_documents-bitovie', ['model'=>$model, 'form'=>$form, 'document_form' => $document_form], false, true) ?>
		
		<?php echo $this->render('_documents-attestat', ['model'=>$model, 'form'=>$form, 'document_form' => $document_form], false, true) ?>
				
	<?php ActiveForm::end(); ?>
</div>