<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\CallTimeForm */
/* @var $form ActiveForm */
?>
<div class="profile-payment-type">

<?php if($model !== null)	{	?>
	<div class="page-body">
		<?= $model->text ?>
	</div>
<?php	}	?>
<?/*
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'payment_type')->radioList($model->paymentsList, [$model->payment_type, 'encode'=>false]) ?>
    
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'button-red']) ?>
        </div>
    <?php ActiveForm::end(); ?>
	
*/?>

</div>
