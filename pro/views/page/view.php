<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Page */

$this->title = $model->name;
//$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-view">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class="page-body"><?= $model->text ?></div>

</div>
