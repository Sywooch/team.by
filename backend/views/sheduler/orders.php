<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;

?>
<h1>Список дел по заказам на <?= $date ?></h1>

<div class="order-index">
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
			[
				'attribute' => 'user',
				'value' => 'user.fio'
			],
			
            'control_note',
            //'category_id',
            //'user_id',
			//['attribute' => 'created_at', 'format' => ['date', 'php:d-m-Y H:i:s']],
			//['attribute' => 'updated_at', 'format' => ['date', 'php:d-m-Y H:i']],
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

            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update}',
			],
        ],
    ]); ?>

</div>
