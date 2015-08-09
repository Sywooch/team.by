<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Page */

//добавляем мета информацию
\common\helpers\DMetaHelper::setMeta($model, $this);

?>
<div class="page-view">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class="page-body"><?= $model->text ?></div>

</div>
