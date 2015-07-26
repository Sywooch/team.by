<?php 
use yii\helpers\Url;
use yii\helpers\Html;



if($model->education != '')	{
	$education_arr = explode('<br />', nl2br($model->education));
}	else	{
	$education_arr = [];
}

//echo'<pre>';print_r($specials);echo'</pre>';//die;
//echo'<pre>';print_r($model->userSpecials);echo'</pre>';die;
?>

<div class="clearfix">
	<a class="catalog-category-list-item__avatar_cnt" href="<?= Url::home(true).Yii::$app->params['avatars-path'].'/'.$model->avatar?>" data-toggle="lightbox">
		<img class="catalog-category-list-item__avatar" src="<?= Url::home(true).Yii::$app->params['avatars-path'].'/thumb_'.$model->avatar?>" alt="">
	</a>

	<div class="catalog-category-list-item__info_cnt">
		<div class="catalog-category-list-item__info_row">
			<p class="catalog-category-list-item__ttl"><?= $model->fio;?></p>	
			<span class="catalog-category-list-item__rating">Рейтинг: <?=$model->total_rating ?> из 5</span>
			<?php 
				if($model->total_rating == 5) echo Html::img('/images/profi-gold.png', ['alt'=>'Супер профи', 'title'=>'Супер профи', 'class'=>'profi_lbl catalog-category-list-item__profi_lbl']);
				if($model->total_rating >= 4) echo Html::img('/images/profi-silver.png', ['alt'=>'Профи', 'title'=>'Профи', 'class'=>'profi_lbl catalog-category-list-item__profi_lbl']);
			?>
		</div>
		<div class="catalog-category-list-item__info_row">
			<?/*<span class="catalog-category-list-item__price">Стоимость работ: <?= \Yii::$app->formatter->asDecimal($model->price); ?> руб.</span>*/?>
			<?php if($model->price_list)	{	?>
				<a class="catalog-category-list-item__pricedownload" href="<?= Url::home(true).Yii::$app->params['pricelists-path'].'/'.$model->price_list?>">Скачать полный прайс</a>
			<?php }	else	{	?>
				<a class="catalog-category-list-item__pricedownload" href="#">Скачать полный прайс</a>
			<?php }	?>
		</div>
		<div class="catalog-category-list-item__info_row">
			<div class="row clearfix">
				<?php if(count($education_arr))	{	?>
				<div class="col-lg-4">
					<p class="bold">Обучение:</p>					
					<ul class="catalog-category-list-item__edu_list">
						<?php foreach($education_arr as $i) echo Html::tag('li', Html::encode($i), ['class' => 'catalog-category-list-item__edu_item']) ?>
					</ul>
				</div>
				<?php	}	?>
				<div class="col-lg-2">
					<p class="bold">Опыт работы:</p>
					<p><?= $model->experience ?></p>
				</div>
				<div class="col-lg-6">
					<p class="bold">Виды услуг:</p>
					<ul class="catalog-category-list-item__uslugi">
						<?php 
							foreach($model->userSpecials as $spec) {
								if(isset($specials[$spec->category_id])) echo Html::tag('li', $specials[$spec->category_id]);
							}
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="catalog-category-list-item__info_row_bottom">
			<?php if(count($model->reviews))	{	?>
				<a href="<?= \Yii::$app->urlManager->createUrl(['reviews/user', 'id' => $model->id]) ?>" class="catalog-category-list-item__reviews">Отзывы (<?= count($model->reviews)?>)</a>
			<?	}	?>
			
			<?php if(count($model->media['examples']))	{	?>
				<a href="<?= \Yii::$app->urlManager->createUrl(['catalog/show', 'id' => $model->id])?>#examples" class="catalog-category-list-item__examples">Примеры работ (<?= count($model->media['examples'])?>)</a>
			<?	}	?>
			
			<a href="<?= \Yii::$app->urlManager->createUrl(['catalog/show', 'id' => $model->id])?>" class="button-blue btn-short catalog-category-list-item__detail">Подробнее о специалисте</a>
			<span class="button-red btn-short catalog-category-list-item__contact contact-to-spec" data-contact="<?= Yii::$app->urlManager->createUrl(['site/zakaz-spec1'])?>">Связаться</span>
		</div>
	</div>
</div>