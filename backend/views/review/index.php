<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ReviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отзывы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить отзыв', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

			[
				'attribute' => 'id',
				'format' => 'raw',
				'value' => 'reviewBackendUrl',
				'headerOptions' => ['width' => '100'],
			],
			
            //'order_id', 
			[
				'attribute' => 'order',
				'format' => 'raw',
				'value' => 'order.orderBackendUrl',
				'headerOptions' => ['width' => '100'],
			],
			
            //'client_id',
			[
				'attribute' => 'client',
				'format' => 'raw',
				'value' => 'client.clientBackendUrl'
			],
			
			[
				'attribute' => 'user',
				'format' => 'raw',
				'value' => 'user.specBackendUrl'
			],
			
            //'user_id',			

            //'review_text:ntext',
            // 'review_rating',
            // 'youtube',
            // 'created_at',
            // 'updated_at',
            // 'status',
            // 'answer_text',
            // 'answer_status',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',],
        ],
    ]); ?>

</div>
