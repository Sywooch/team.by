<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserNotify */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Добавления уведомления специалистам';
$this->params['breadcrumbs'][] = ['label' => 'Специалисты', 'url' => ['/spec/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-notify-add">
    
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['action'=>'/notify/to-spec-add']); ?>

    <?php
		//echo'<pre>';print_r($model->user_ids);echo'</pre>';//die;
		foreach($model->user_ids as $user_id) {
			echo Html::activeHiddenInput($model, 'user_ids[]', ['value'=>$user_id]);
		}
		
		//Html::activeHiddenInput($model, 'user_ids')
	?>

    <?= $form->field($model, 'msg')->textarea(['rows'=>5]) ?>


    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
