<?php
use yii\helpers\Url;
use yii\helpers\Html;

\frontend\assets\BootstrapLightboxAsset::register($this);

\frontend\assets\JcarouselAsset::register($this);



$this->title = $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Каталог специалистов', 'url' => ['index']];

foreach($parents as $parent) {
	if($parent->id <> 1)
		$this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => ['category', 'category'=>$parent->path]];
}
$this->params['breadcrumbs'][] = $category->name;

if($model->education != '')	{
	$education_arr = explode('<br />', nl2br($model->education));
}	else	{
	$education_arr = [];
}

//print_r($education_arr);

$model_awards = [];
$model_examples = [];

foreach($model->userMedia as $media)	{
	switch($media->media_id)	{
		case 1:
			$model_awards[] = $media->filename;
			break;
		case 2:
			$model_examples[] = $media->filename;
			break;
	}
}

$rating_active = 20 * $model->total_rating; // максимальная оценка 5 это 100%.  Значит каждая единица = 20%
//echo'<pre>';print_r($model->userCategories[0]->category);echo'</pre>';
?>

<div class="catalog-item">
	<div class="catalog-item__body clearfix">
			<div class="catalog-item_body_left">
				<a class="catalog-item_body__avatar_cnt" href="<?= Url::home(true).Yii::$app->params['avatars-path'].'/'.$model->avatar?>" data-toggle="lightbox">
					<img class="catalog-item_body__avatar" src="<?= Url::home(true).Yii::$app->params['avatars-path'].'/thumb_'.$model->avatar?>" alt="">
				</a>
				
				<ul class="catalog-item_body__awards">
					<?php
						foreach($model_awards as $item)
							echo Html::tag('li', Html::a(Html::img(Url::home(true).Yii::$app->params['awards-path'].'/thumb_'.$item), Url::home(true).Yii::$app->params['awards-path'].'/'.$item, ['data-toggle'=>'lightbox', 'data-gallery'=>'awards-images']), ['class'=>'catalog-item_body__awards_item']);
					?>
				</ul>
				
			</div>
			<div class="catalog-item_body_right">
				<div class="catalog-item_body__info_row clearfix">
					<div class="catalog-item_body__ttl_cnt catalog-item_body__ttl_profi">
						<h1 class="catalog-item_body__ttl"><?= $model->fio;?></h1>
						<p class="catalog-item_body__town">Город: <?= $model->userRegion->name;?></p>
					</div>
					
					<?php if($model->to_client == 1)	{	?>
						<p class="catalog-item_body__to_client">Выезд к клиенту</p>
					<?php	}	?>
					
					<div class="catalog-item_body__rating">
						<span class="catalog-item_body__rating_txt">Рейтинг <?=$model->total_rating?></span>
						<div class="catalog-item_body__rating_cnt">
							<div class="catalog-item_body__rating_inactive"></div>
							<div class="catalog-item_body__rating_active" style="width:<?=$rating_active?>%;"></div>
						</div>
					</div>
				</div>
				<div class="catalog-item_body__info_row catalog-item_body__about clearfix">
					<?= $model->about ?>
				</div>
				
				<div class="catalog-item_body__info_row catalog-item_body__uslugi clearfix">
					<p class="catalog-item_body__uslugi_ttl">Виды услуг</p>
					<ul class="catalog-item_body__uslugi_list row clearfix">
						<?php foreach($model->userSpecials as $user_spec)	{	?>
							<li class="catalog-item_body__uslugi_item col-lg-6">
								<div class="row">
									<p class="col-lg-6">• <?= $user_spec->category->name ?></p>
									<p class="col-lg-6"><?= \Yii::$app->formatter->asDecimal($user_spec->price); ?></p>
								</div>
							</li>
						<?php	}	?>
					</ul>	
					
					<?php if($model->price_list) echo Html::a('Скачать полный прайс', Url::home(true).Yii::$app->params['pricelists-path'].'/'.$model->price_list, ['class'=>'catalog-item_body__pricelist'])?>
					
				</div>
				
				<div class="catalog-item_body__info_row_bottom row clearfix">
					<?php if(count($education_arr))	{	?>
						<div class="col-lg-6">
							<p class="dinpro-b">Обучение</p>
							<ul class="catalog-item_body__edu_list">
								<?php foreach($education_arr as $i) echo Html::tag('li', Html::encode($i)) ?>
							</ul>

						</div>
					<?php	}	?>
					<div class="col-lg-6">
						<p class="dinpro-b">Опыт работы</p>
						<p><?= $model->experience ?></p>
					</div>
				</div>
				
				<a href="#" class="button-red catalog-item_body__contact_spec">Связаться со специалистом</a>
				
			</div>
			
	</div>
	
	<?php if(count($model_examples))	{	?>
		<div id="examples" class="catalog-item__examples">
			<p class="catalog-item__ttl">Примеры работ (<?= count($model_examples)?>)</p>
			
			<?php if(count($model_examples) > 5)	{	?>
				<div class="catalog-item__examples_list catalog-item__examples_jcarousel jcarousel-wrapper">
					<div class="jcarousel">
						<ul>
							<?php 
								foreach($model_examples as $item)
									echo Html::tag('li', Html::a(Html::img(Url::home(true).Yii::$app->params['examples-path'].'/thumb_'.$item), Url::home(true).Yii::$app->params['examples-path'].'/'.$item, ['data-toggle'=>'lightbox', 'data-gallery'=>'examples-images']), ['class'=>'catalog-item__examples_item']);
							?>
						</ul>
					</div>

					<a href="#" class="jcarousel-control-prev">&lsaquo;</a>
					<a href="#" class="jcarousel-control-next">&rsaquo;</a>

					<?/*<p class="jcarousel-pagination"></p>*/?>
				</div>
				
			
			<?php	}	else	{	?>
			
				<ul class="catalog-item__examples_list catalog-item__examples_list_1">
				<?php 
					foreach($model_examples as $item)
						echo Html::tag('li', Html::a(Html::img(Url::home(true).Yii::$app->params['examples-path'].'/thumb_'.$item), Url::home(true).Yii::$app->params['examples-path'].'/'.$item, ['data-toggle'=>'lightbox', 'data-gallery'=>'examples-images']), ['class'=>'catalog-item__examples_item']);
				?>
				</ul>
			<?php	}	?>
		</div>
	<?	}	?>
	
	<?php echo $this->render('_reviews', ['model'=>$model] ) ?>
	
</div>


