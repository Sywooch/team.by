<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ZakazSpec1 */
/* @var $form ActiveForm */
?>
<div class="catalog-zakaz-spec1">

    <?php $form = ActiveForm::begin(); ?>
		<?= $form->field($model, 'user_id')->hiddenInput() ?>
		<?= $form->field($model, 'spec_name')->hiddenInput() ?>
        <?= $form->field($model, 'phone')->textInput(['class'=>'form-control phone-input']) ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'comment')->textarea() ?>
    
        <div class="form-group cleafrix">
            <?= Html::submitButton('Отправить', ['class' => 'button-red']) ?>
            <p class="catalog-zakaz-spec1-notice">Отправляя заявку, подтверждаюознакомление и согласие с <a href="#" target="_blank">Условиями использования</a></p>
            
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- catalog-zakaz-spec1 -->
