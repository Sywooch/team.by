<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\UserToAdministration */

$this->title = 'Create User To Administration';
$this->params['breadcrumbs'][] = ['label' => 'User To Administrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-to-administration-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
