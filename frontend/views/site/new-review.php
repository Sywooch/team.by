<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\AddReviewForm */
/* @var $form ActiveForm */
?>
<div class="site-new-review">

    <?php $form = ActiveForm::begin(); ?>

        <?//= $form->field($model, 'user_id') ?>
        <?= $form->field($model, 'rating') ?>
        <?= $form->field($model, 'phone') ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'video') ?>
        <?= $form->field($model, 'comment') ?>
        <?//= $form->field($model, 'foto') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-new-review -->
