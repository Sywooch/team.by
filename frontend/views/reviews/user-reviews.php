<?php
/* @var $this yii\web\View */
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;

\frontend\assets\BootstrapLightboxAsset::register($this);

$title = 'Отзывы о специалисте '. $user->fio;
$this->title = $title;

$this->params['breadcrumbs'] = [
	['label' => $title]	
];

?>
<div class="page-reviews">

	<h1><?= $title ?></h1>
	
	<div class="reviews-list-cnt">

		<?php
		echo ListView::widget( [
			'dataProvider' => $dataProvider,
			'itemView' => '_item',
			'summary' => '',
			'id' => 'items-list',
			'options' => ['class' => 'list-view reviews_list'],
			'itemOptions' => ['class'=>'reviews_item'],
			'layout' => '{pager}{items}{pager}',
			//'viewParams'=> ['specials'=>$specials],
		] );
		?>
	
	</div>
</div>