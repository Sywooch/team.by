<?php
use yii\helpers\Url;
use yii\helpers\Html;

use frontend\assets\BootstrapLightboxAsset;

BootstrapLightboxAsset::register($this);

$this->params['breadcrumbs'][] = ['label' => 'Каталог специалистов', 'url' => ['index']];

foreach($parents as $parent) {
	if($parent->id <> 1)
		$this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => ['category', 'category'=>$parent->path]];
}
$this->params['breadcrumbs'][] = $category->name;


//echo'<pre>';print_r($model->userRegion->name);echo'</pre>';
?>

<div class="catalog-item">
	<div class="catalog-item__body clearfix">
			<div class="catalog-item_body_left">
				<a class="catalog-item_body__avatar_cnt" href="<?= Url::home(true).Yii::$app->params['avatars-path'].'/'.$model->avatar?>" data-toggle="lightbox">
					<img class="catalog-item_body__avatar" src="<?= Url::home(true).Yii::$app->params['avatars-path'].'/thumb_'.$model->avatar?>" alt="">
				</a>
				
			</div>
			<div class="catalog-item_body_right clearfix">
				<div class="catalog-item_body__info_row">
					<div class="catalog-item_body__ttl_cnt">
						<p class="catalog-item_body__ttl"><?= $model->fio;?></p>
						<p class="catalog-item_body__town">Город: <?= $model->userRegion->name;?></p>
					</div>
					<div class="catalog-item_body__rating">
						<span class="catalog-item_body__rating_txt">Рейтинг 3.6</span>
						<div class="catalog-item_body__rating_cnt">
							<div class="catalog-item_body__rating_inactive"></div>
							<div class="catalog-item_body__rating_active"></div>
						</div>
					</div>
				</div>
			</div>
			
	</div>
</div>


