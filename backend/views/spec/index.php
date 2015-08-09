<?php

use yii\helpers\Html;
use yii\grid\GridView;

use common\models\User;
use common\models\Category;

//use backend\models\Category;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Специалисты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
   
<?=Html::beginForm(['notify/to-spec'], 'post');?>
<?/*
    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
*/?>
   
   <?=Html::submitButton('Отправить уведомления', ['class' => 'btn btn-info',]);?>
   
   
   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			
			[
				'class' => 'yii\grid\CheckboxColumn',
				'name' => 'user-ids',
			],

			[
				'attribute'=>'id',
				'headerOptions' => ['width' => '70'],				
			],
			
			[
				'attribute' => 'fio',
				'format' => 'raw',
				'value' => 'specBackendUrlInner'
			],
			
            'email:email',
			[
				'attribute'=>'category_id',
				'format' => 'raw',
				'content'=>function($data){
					return $data->userCategoriesList;
				},
				'filter' => $searchModel->getDropdownCatList(),
				
			],
            
			[
				'attribute'=>'user_status',
				//'label'=>'Родительская категория',
				'format'=>'text', // Возможные варианты: raw, html
				'content'=>function($data){
					return $data->userStatusTxt;
				},
				'filter' => User::getUserStatuses(),
				//'headerOptions' => ['width' => '100'],
			],			
			
			[
				'attribute'=>'region_id',
				//'label'=>'Родительская категория',
				'format'=>'text', // Возможные варианты: raw, html
				'content'=>function($data){
					return $data->userRegion->name;
				},
				'filter' => $searchModel->getDropdownRegionsList(),
				//'headerOptions' => ['width' => '100'],
			],			
			/*
			[
				'attribute'=>'is_active',
				'format'=>'text',
				'content'=>function($data){
					return $data->userActivity;
				},
				'filter' => User::getUserActivityList(),
			],			
			*/
			
            // 'created_at',
            // 'updated_at',

            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update} {delete}',
			],

        ],
    ]); ?>
    
<?= Html::endForm();?>     

</div>
