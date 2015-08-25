<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserToAdministration */

$this->title = 'Сообщение №: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Сообщения для администрации', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Просмотр';
?>
<div class="user-to-administration-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <h2>специалист: <?= Html::encode($model->user->fio)?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
