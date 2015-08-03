<?php
use yii\widgets\ListView;

$title = 'Уведомления';
$this->title = $title;

$this->params['breadcrumbs'] = [
	['label' => 'Личный кабинет', 'url' => '/profile'],
	['label' => $title]
]
	

?>
<div class="notify-page">

	<h1><?= $title?></h1>
	
	<?php
	echo ListView::widget( [
		'dataProvider' => $dataProvider,
		'itemView' => '_item-notify',
		'summary' => '',
		'id' => 'items-list',
		'options' => ['class' => 'list-view notify-list-view'],
		'itemOptions' => ['class'=>'notify_row notify_item'],
		'layout' => '{items}{pager}',
		//'viewParams'=> ['specials'=>$specials],
	] );
	?>	
</div>