<?php

use yii\helpers\Html;
use yii\grid\GridView;

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

            'id',
			[
				'attribute' => 'client',
				'value' => 'client.fio'
			],
			
            'category_id',
            'user_id',
			//['attribute' => 'created_at', 'format' => ['date', 'php:d-m-Y H:i:s']],
			['attribute' => 'updated_at', 'format' => ['date', 'php:d-m-Y H:i']],
            // 'updated_at',
            // 'date_control',
            // 'descr:ntext',
            // 'price1',
            // 'price',
            // 'fee',
            // 'status',
            // 'payment_status',
            // 'review_text:ntext',
            // 'review_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
