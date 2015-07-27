<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserToAdministration */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-to-administration-form">

    <?php $form = ActiveForm::begin(); ?>

    <?//= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'subject')->textInput(['disabled'=>'disabled']) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 7, 'disabled'=>'disabled']) ?>

    <?= $form->field($model, 'status')->dropDownList($model->statuses, [$model->status, 'disabled'=>'disabled']) ?>

    <?= $form->field($model, 'answer')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Отправить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
