<?php
/* @var $this yii\web\View */

use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;
?>







<?php
echo ListView::widget( [
	'dataProvider' => $dataProvider,
	'itemView' => '_item-modal',
	'summary' => '',
	'id' => 'items-list',
	'options' => ['class' => 'list-view search-modal-list-view'],
	'itemOptions' => ['class'=>'search-modal-list-item'],
	'layout' => '{items}',
	//'viewParams'=> ['specials'=>$specials],
] );
?>
