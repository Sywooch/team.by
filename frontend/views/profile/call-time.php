<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\CallTimeForm */
/* @var $form ActiveForm */
?>
<div class="profile-call-time">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'call_from') ?>
        <?= $form->field($model, 'call_to') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- profile-call-time -->
