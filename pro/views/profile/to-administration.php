<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\ProfileAnketaForm  */
/* @var $form ActiveForm */

use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ActiveForm;

//\pro\assets\RegAsset::register($this);
//\pro\assets\RegStep2Asset::register($this);
//\pro\assets\BootstrapLightboxAsset::register($this);
//\pro\assets\FormStylerAsset::register($this);

$title = 'Связаться с администрацией';
$this->title = $title;

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
			'options'=> ['enctype' => 'multipart/form-data' ],			
			'id'=>'to-administration-frm',
		] ); ?>
		
		<div class="row clearfix">
			<div class="col-lg-6"><?= $form->field($model, 'subject') ?></div>
			<div class="col-lg-6"><p class="to_administration_txt">Это канал для прямой связи с администрацией. Все ваши вопросы, предложения и замечания будут рассмотрены немедленно.</p></div>
			<div class="col-lg-6" style="clear:both;"><?= $form->field($model, 'body')->textarea(['rows'=>7]) ?></div>
		</div>
		
		
		
		
		<div class="form-group">
			<?= Html::submitButton('Отправить', ['class' => 'button-red']) ?>
		</div>
	<?php ActiveForm::end(); ?>
