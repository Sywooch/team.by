<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $model frontend\models\ZakazSpec2 */
/* @var $form ActiveForm */
?>
<div class="catalog-zakaz-spec2">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'email') ?>
        
		<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
			'template' => '<div class="row"><div class="col-lg-2">{image}</div><div class="col-lg-10">{input}</div></div>',
		]) ?>
    
        <div class="form-group">
            <?= Html::submitButton('Отправить', ['id'=>'zakaz-spec2-btn', 'class' => 'button-red']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- catalog-zakaz-spec2 -->
