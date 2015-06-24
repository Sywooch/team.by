<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;


//echo'<pre>';print_r($dataProvider->models);echo'<pre>';die;
foreach($dataProvider->models as $model) {
	$separator = '';
	for ($x=0; $x++ < $model->depth;) $separator .= ' - ';
	$model->name = $separator.$model->name;
}
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'tree',
            //'lft',
            //'rgt',
            //'depth',
             'name',
            // 'description:ntext',
            // 'meta_title',
            // 'meta_keyword',
            // 'meta_descr:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
