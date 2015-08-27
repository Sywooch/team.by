<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Регионы';
$this->params['breadcrumbs'][] = $this->title;


//echo'<pre>';print_r($dataProvider->models);echo'<pre>';die;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'columns' => [
            [
				'class' => 'yii\grid\SerialColumn',
				'headerOptions' => ['width' => '75'],
			],

			[
				'attribute' => 'id',
				'headerOptions' => ['width' => '100'],
			],

			[
				'attribute'=>'name',
				'format'=>'html', // Возможные варианты: raw, html
				'content'=>function($data){
					$separator = '';
					for ($x=1; $x++ < $data->depth;) $separator .= ' - ';					
					$res = $separator . Html::a($data->name, ['region/update', 'id'=>$data->id]);
					return $res;
				},
			],			

            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update} {delete} {moveup} {movedown}',
				'buttons' => [
					'moveup' => function($url, $model) {
						$url = \yii\helpers\Url::toRoute(['region/moveup', 'id' => $model->id]);
						return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', $url, [
						'title' => 'Переместить вверх',
						//'data-pjax' => '0', // нужно для отключения для данной ссылки стандартного обработчика pjax. Поверьте, он все портит
						//'class' => 'grid-action' // указываем ссылке класс, чтобы потом можно было на него повесить нужный JS-обработчик
						]);
					},
					'movedown' => function($url, $model) {
						$url = \yii\helpers\Url::toRoute(['region/movedown', 'id' => $model->id]);
						return Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', $url, [
						'title' => 'Переместить вниз',
						//'data-pjax' => '0', // нужно для отключения для данной ссылки стандартного обработчика pjax. Поверьте, он все портит
						//'class' => 'grid-action' // указываем ссылке класс, чтобы потом можно было на него повесить нужный JS-обработчик
						]);
					}
				],
				'headerOptions' => ['width' => '100'],
			],
        ],
    ]); ?>

</div>
