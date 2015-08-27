<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

\frontend\assets\PhoneInputAsset::register($this);

$this->title = 'Клиенты';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="client-index">

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
				'attribute' => 'fio',
				'format' => 'raw',
				'value' => 'clientBackendUrlInner',
			],

			[
				'attribute' => 'phone',
				'filterInputOptions' => ['class'=>'form-control phone-input'],
			],

            //'phone',
            'email:email',
            'info',

            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update} {delete}',
			],
		],
    ]); ?>

</div>
