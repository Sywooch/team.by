<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\AddAnswerReviewForm */
/* @var $form ActiveForm */
?>
<div class="profile-add-answer">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'answer_text') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- profile-add-answer -->
