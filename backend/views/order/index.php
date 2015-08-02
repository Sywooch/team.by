<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

use backend\models\OrderForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Новый заказ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
				
			[
				'attribute'=>'id',
				'headerOptions' => ['width' => '100'],
				/*
				//'label' => 'Ссылка',
				'format' => 'raw',
				'value' => function($data){
					return Html::a(
						$data->id,
						Url::to('order/update', ['id'=>$data->id]),
						[
							'title' => 'Смелей вперед!',
							//'target' => '_blank'
						]
					);
				},
				*/
			],
			           
			[
				'attribute' => 'client',
				'value' => 'client.fio'
			],
			
			[
				'attribute' => 'user',
				'value' => 'user.fio'
			],
			
			[
				'attribute'=>'status',
				//'label'=>'Родительская категория',
				'format'=>'text', // Возможные варианты: raw, html
				'content'=>function($data){
					return $data->orderStatusTxt;
				},
				'filter' => OrderForm::getStatuses(),
			],			

			['attribute' => 'updated_at', 'format' => ['date', 'php:d-m-Y H:i']],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',],
        ],
    ]); ?>

</div>
