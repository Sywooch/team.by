<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\CallTimeForm */
/* @var $form ActiveForm */
?>
<div class="profile-payment-type">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'payment_type') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'button-red']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>
