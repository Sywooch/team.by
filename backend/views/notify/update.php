<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserNotify */

$this->title = 'Update User Notify: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Notifies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-notify-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
