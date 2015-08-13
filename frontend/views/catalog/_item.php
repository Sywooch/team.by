<?php 
use yii\helpers\Url;
use yii\helpers\Html;

use common\helpers\DStringHelper;



if($model->education != '')	{
	$education_arr = explode('<br />', nl2br($model->education));
}	else	{
	$education_arr = [];
}

//echo'<pre>';print_r($specials);echo'</pre>';//die;
//echo'<pre>';print_r($model->userSpecials);echo'</pre>';die;

$rating_active = 20 * $model->total_rating; // максимальная оценка 5 это 100%.  Значит каждая единица = 20%
?>


<div class="catalog-category-list-item-cnt">
	<div class="clearfix">
		<a class="catalog-category-list-item__avatar_cnt" href="<?= Url::home(true).Yii::$app->params['avatars-path'].'/'.$model->avatar?>" data-toggle="lightbox">
			<img class="catalog-category-list-item__avatar" src="<?= Url::home(true).Yii::$app->params['avatars-path'].'/thumb_'.$model->avatar?>" alt="">
		</a>

		<div class="catalog-category-list-item__info_cnt">
			
			<div class="catalog-category-list-item__info_row">
				<div class="catalog-category-list-item__ttl">
					<a href="<?= \Yii::$app->urlManager->createUrl(['catalog/show', 'id' => $model->id])?>" title="<?= $model->fio;?>"><?= $model->fio;?></a>
					<?/*
					<ul>
					<?php foreach($model->userRegionsList as $region)	{	?>
						<li><?= $region->name ?></li>
					<?php	}	?>
					</ul>
					*/?>
				</div>
				
				<div class="catalog-item_body__rating">				
					<span class="catalog-item_body__rating_txt">Рейтинг <?=\Yii::$app->formatter->asDecimal($model->total_rating) ?></span>
					<div class="catalog-item_body__rating_cnt">
						<div class="catalog-item_body__rating_inactive"></div>
						<div class="catalog-item_body__rating_active" style="width:<?=$rating_active?>%;"></div>
					</div>
				</div>
				
				
				<?php echo $model->medalImage ?>
				
				
				<?/*
				<span class="catalog-category-list-item__rating">Рейтинг: <?=\Yii::$app->formatter->asDecimal($model->total_rating) ?> из 5</span>
				<?php 
					if($model->total_rating == 5) echo Html::img('/images/profi-gold.png', ['alt'=>'Супер профи', 'title'=>'Супер профи', 'class'=>'profi_lbl catalog-category-list-item__profi_lbl']);
					if($model->total_rating >= 4) echo Html::img('/images/profi-silver.png', ['alt'=>'Профи', 'title'=>'Профи', 'class'=>'profi_lbl catalog-category-list-item__profi_lbl']);
				?>
				*/?>

				
				
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
					<div class="col-lg-5">
						<p class="bold">Виды услуг:</p>
						<ul class="catalog-category-list-item__uslugi">
							<?php 
								foreach($model->userSpecials as $spec) {
									if(isset($specials[$spec->category_id])) echo Html::tag('li', $specials[$spec->category_id]);
								}
							?>
						</ul>
					</div>
					<div class="col-lg-3">
						<p class="bold">Опыт работы:</p>
						<p><?= DStringHelper::getIntroText(200, $model->experience) ?></p>
					</div>
					
				
					<?php if(count($education_arr))	{	?>
					<div class="col-lg-4">
						<p class="bold">Обучение:</p>					
						<ul class="catalog-category-list-item__edu_list">
							<?php foreach($education_arr as $i) echo Html::tag('li', Html::encode($i), ['class' => 'catalog-category-list-item__edu_item']) ?>
						</ul>
					</div>
					<?php	}	?>
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
				<span class="button-red btn-short catalog-category-list-item__contact contact-to-spec" data-contact="<?= Yii::$app->urlManager->createUrl(['site/zakaz-spec1'])?>" data-spec="<?= $model->fio;?>">Связаться</span>
			</div>
		</div>
	</div>
</div>

<?php if(count($model->reviews))	{	?>
	<div class="catalog-category-list-reviews">
		<button type="button" class="catalog-category-list-popup__close">×</button>
		<div class="catalog-category-list-reviews-cnt">
			<ul class="reviews_list">
				<?php foreach($model->reviews as $key=>$review)	{	?>
					<li class="reviews_item">
						<? echo $this->render('_review-item', ['model'=>$review])?>
					</li>
					<?php	if($key >= 2) break;	?>
				<?php	}	?>
			</ul>

			<div class="catalog-item__reviews_bottom">
				<a href="<?= \Yii::$app->urlManager->createUrl(['reviews/user', 'id' => $model->id]) ?>" id="catalog-item__show_reviews" class="button-blue catalog-item__show_reviews">Читать все отзывы</a>
			</div>
		</div>
	</div>
<?	}	?>

<?php if(count($model->media['examples']))	{	?>
	<div class="catalog-category-list-examples">
		<button type="button" class="catalog-category-list-popup__close">×</button>
		<div class="catalog-category-list-examples-cnt">
				<ul class="catalog-item__examples_list">
				<?php 
					foreach($model->media['examples'] as $key=>$item) {
						echo Html::tag('li', Html::a(Html::img(Url::home(true).Yii::$app->params['examples-path'].'/thumb_'.$item), Url::home(true).Yii::$app->params['examples-path'].'/'.$item, ['data-toggle'=>'lightbox', 'data-gallery'=>'examples-images']), ['class'=>'catalog-item__examples_item']);
						if($key > 9) break;
					}
				?>
				</ul>

		</div>
	</div>
<?	}	?>
