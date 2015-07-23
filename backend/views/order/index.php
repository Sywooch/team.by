<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'client_id',
            'clientName',
            'category_id',
            'user_id',
            ['attribute' => 'created_at', 'format' => ['date', 'php:d-m-Y H:i:s']],
            // 'date_control',
            // 'info:ntext',
            // 'price1',
            // 'price',
            // 'status',
            // 'review_text:ntext',
            // 'review_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
