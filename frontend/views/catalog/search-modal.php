<?php
/* @var $this yii\web\View */

use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;
?>







<?php
if(count($catdataProvider->models)) {
	echo ListView::widget( [
		'dataProvider' => $catdataProvider,
		'itemView' => '_item-cat-modal',
		'summary' => '',
		'id' => 'items-list',
		'options' => ['class' => 'list-view search-modal-list-view'],
		'itemOptions' => ['class'=>'search-modal-list-item'],
		'layout' => '{items}',
		//'viewParams'=> ['specials'=>$specials],
	] );
}
?>

<?php
if(count($dataProvider->models)) {
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
}
?>
<?php if(count($dataProvider->models) == 0 && count($catdataProvider->models) == 0) { ?>
	<div class="empty">Ничего не найдено.</div>
<?php	}	?>