<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RegStep1Form */
/* @var $form ActiveForm */
?>
<div class="site-reg-step1">

    <?php $form = ActiveForm::begin(); ?>

        <?//= $form->field($model, 'user_type') ?>
        
        <?= $form->field($model, 'user_type')->radioList(Yii::$app->params['UserTypesArray'], [$model->user_type]) ?>
        
        <?= $form->field($model, 'fio') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'phone') ?>
        <?= $form->field($model, 'password') ?>
        <?= $form->field($model, 'passwordRepeat') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-reg-step1 -->
