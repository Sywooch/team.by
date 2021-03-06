<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Page */

//добавляем мета информацию
\common\helpers\DMetaHelper::setMeta($model, $this);

$this->params['breadcrumbs'][] = $model->name;
?>
<div class="page-view page-<?= $alias ?>">

    <h1><?= Html::encode($model->name) ?></h1>
    
    <div class="page-body"><?= $model->text ?></div>

</div>
