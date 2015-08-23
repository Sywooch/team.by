<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\ProfileAnketaForm  */
/* @var $form ActiveForm */

use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ActiveForm;

\pro\assets\DocumentsAsset::register($this);
\pro\assets\BootstrapLightboxAsset::register($this);
\pro\assets\FormStylerAsset::register($this);

$title = 'Документы';
$this->title = \Yii::$app->params['sitename'] .' | ' . $title;

$this->params['breadcrumbs'] = [
	['label' => 'Личный кабинет', 'url' => '/profile'],
	['label' => $title]
];
	

//echo'<pre>';print_r($categories);echo'</pre>';
//echo'<pre>';print_r(Yii::$app->request->post());echo'</pre>';//die;

//$json_str = json_encode(Yii::$app->request->post()['ProfileAnketaForm ']);
//echo'<pre>';print_r(json_decode($json_str, 1));echo'</pre>';//die;
//echo'<pre>';print_r(($json_str));echo'</pre>';//die;
//echo'<pre>';print_r($model);echo'</pre>';//die;

$errors = $model->getErrors();
//echo'<pre>';print_r($errors);echo'</pre>';//die;



$categories_l2_arr = [];
?>
<div class="to_administration">
	<h1><?= $title?></h1>

		<?php $form = ActiveForm::begin([
			//'options'=> ['enctype' => 'multipart/form-data' ],
			'id'=>'documents-frm',
		] ); ?>
		
		<?php echo $this->render('_documents-reg-file', ['model'=>$model, 'form'=>$form], false, true) ?>	
		
		<?php echo $this->render('_documents-license', ['model'=>$model, 'form'=>$form], false, true) ?>
			
		<?php echo $this->render('_documents-bitovie', ['model'=>$model, 'form'=>$form], false, true) ?>
		
		<?php echo $this->render('_documents_other', ['model'=>$model,'document_form' => $document_form], false, true) ?>
		
		
		<div class="form-group clearfix">
			<?= Html::submitButton('Сохранить', ['class' => 'button-red pull-right']) ?>
		</div>
	<?php ActiveForm::end(); ?>
</div>