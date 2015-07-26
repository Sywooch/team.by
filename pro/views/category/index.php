<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;


//echo'<pre>';print_r($dataProvider->models);echo'<pre>';die;
foreach($dataProvider->models as $model) {
	$separator = '';
	for ($x=1; $x++ < $model->depth;) $separator .= ' - ';
	$model->name = $separator.$model->name;
}
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Новая категория', ['create'], ['class' => 'btn btn-success']) ?>
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

            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update} {delete} {moveup} {movedown}',
				'buttons' => [
					'moveup' => function($url, $model) {
						$url = \yii\helpers\Url::toRoute(['category/moveup', 'id' => $model->id]);
						return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', $url, [
						'title' => 'Переместить вверх',
						//'data-pjax' => '0', // нужно для отключения для данной ссылки стандартного обработчика pjax. Поверьте, он все портит
						//'class' => 'grid-action' // указываем ссылке класс, чтобы потом можно было на него повесить нужный JS-обработчик
						]);
					},
					'movedown' => function($url, $model) {
						$url = \yii\helpers\Url::toRoute(['category/movedown', 'id' => $model->id]);
						return Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', $url, [
						'title' => 'Переместить вниз',
						//'data-pjax' => '0', // нужно для отключения для данной ссылки стандартного обработчика pjax. Поверьте, он все портит
						//'class' => 'grid-action' // указываем ссылке класс, чтобы потом можно было на него повесить нужный JS-обработчик
						]);
					}
				]				
			],
        ],
    ]); ?>

</div>
