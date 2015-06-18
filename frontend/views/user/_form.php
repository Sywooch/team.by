<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

///echo'<pre>';var_dump($allRoles);echo'</pre>';die;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput() ?>
    
    <?= $form->field($model, 'status')->dropDownList($model->getStatusesArray(), [$model->status]) ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?php if($model->isNewRecord) echo $form->field($model, 'password')->textInput() ?>
    
    <div class="form-group">
    	<?= Html::label( 'Роль пользователя','role_name', ['class'=>'control-label'] );?>
    	<?= Html::dropDownList('role_name', $modelHasRoles, $allRoles, ['class' => 'form-control']);?>
	</div>
   
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php if(!$model->isNewRecord) echo Html::a(Yii::t('app', 'Изменить пароль'), ['change-password', 'id'=>$model->id ], ['class' => 'btn btn-primary']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
