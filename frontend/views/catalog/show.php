<?php
use yii\helpers\Url;
use yii\helpers\Html;

use common\helpers\DPriceHelper;

\frontend\assets\BootstrapLightboxAsset::register($this);

\frontend\assets\JcarouselAsset::register($this);
\frontend\assets\FormStylerAsset::register($this);
\frontend\assets\AjaxUploadAsset::register($this);



$this->title = $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Каталог специалистов', 'url' => ['index']];

foreach($parents as $parent) {
	if($parent->id <> 1)
		$this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => ['category', 'category'=>$parent->path]];
}
//$this->params['breadcrumbs'][] = $category->name;
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['category', 'category'=>$category->path]];

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

$userSpecialsList = $model->userSpecialsList;
//echo'<pre>';print_r($userSpecialsList);echo'</pre>';die;
?>

<div class="catalog-item">
	<div class="catalog-item__body clearfix">
			<div class="catalog-item_body_left">
				<?/*
				<a class="catalog-item_body__avatar_cnt" href="<?= Url::home(true).Yii::$app->params['avatars-path'].'/'.$model->avatar?>" data-toggle="lightbox">
					<img class="catalog-item_body__avatar" src="<?= Url::home(true).Yii::$app->params['avatars-path'].'/thumb_'.$model->avatar?>" alt="">
				</a>
				*/?>
				
				<span class="catalog-item_body__avatar_cnt">
					<?php if(file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['avatars-path'].'/'.$model->avatar) && file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['avatars-path'].'/thumb_'.$model->avatar)) { ?>
						<img class="catalog-item_body__avatar" src="<?= Url::home(true).Yii::$app->params['avatars-path'].'/thumb_'.$model->avatar?>" alt="">
					<?php }	else	{	?>
						<img class="catalog-category-list-item__avatar" src="<?= Url::home(true) ?>/images/no-avatar.jpg" alt="" width="277" height="282" />
					<?php }	?>						
				</span>


				
				<?= $model->youtubeBlock ?>

				
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
						<p class="catalog-item_body__town"><?= $model->townsList ?></p>
					</div>

					<?php if($model->to_client == 1)	{	?>
						<p class="catalog-item_body__to_client">Выезд к клиенту</p>
					<?php	}	?>
					
					<div class="catalog-item_body__rating">
						<span class="catalog-item_body__rating_txt">Рейтинг <?=\Yii::$app->formatter->asDecimal($model->total_rating) ?></span>
						<div class="catalog-item_body__rating_cnt">
							<div class="catalog-item_body__rating_inactive"></div>
							<div class="catalog-item_body__rating_active" style="width:<?=$rating_active?>%;"></div>
						</div>
					</div>

					<?php echo $model->medalImage ?>
				</div>

				<div class="catalog-item_body__info_row catalog-item_body__about clearfix">
					<?= nl2br($model->about) ?>
					
					<?php if($model->specialization)	{	?>
						<p class="catalog-item_body__uslugi_ttl pt-10">Специализация</p>
						<p><?= $model->specialization ?></p>
					<?php	}	?>
				</div>

				<div class="catalog-item_body__info_row catalog-item_body__uslugi clearfix">
					<p class="catalog-item_body__uslugi_ttl">Виды услуг</p>

					<ul class="catalog-item_body__uslugi_list row clearfix">
						<?php $i = 1;	?>
						<?php foreach($userSpecialsList as $user_spec)	{	?>
							<?php 
								if(($i-1)%2 == 0) $clr = ' clear';
									else $clr = '';

								$i++;
							?>
							<li class="catalog-item_body__uslugi_item col-lg-6 <?= $clr?>">
								<div class="row">
									<p class="col-lg-6">• <?= $user_spec->category->name ?></p>
									<p class="col-lg-6"><?= $user_spec->price ? DPriceHelper::formatPrice($user_spec->price * $model->regionRatio) : ''; ?><?= $user_spec->unit ? (' за '.$user_spec->unit) : ''?></p>
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
				
				<span class="button-red catalog-item_body__contact_spec contact-to-spec" data-contact="<?= Yii::$app->urlManager->createUrl(['site/zakaz-spec1'])?>" data-spec="<?= $model->fio;?>" data-spec_id="<?= $model->id;?>">Связаться со специалистом</span>
				
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
			
				<ul class="catalog-item__examples_list">
				<?php 
					foreach($model_examples as $item)
						echo Html::tag('li', Html::a(Html::img(Url::home(true).Yii::$app->params['examples-path'].'/thumb_'.$item), Url::home(true).Yii::$app->params['examples-path'].'/'.$item, ['data-toggle'=>'lightbox', 'data-gallery'=>'examples-images']), ['class'=>'catalog-item__examples_item']);
				?>
				</ul>
			<?php	}	?>
		</div>
	<?	}	?>
	
	<?php echo $this->render('_reviews', ['model'=>$model,'reviews_list'=>$reviews_list,'reviews_count'=>$reviews_count] ) ?>
	
	<?php echo $this->render('_related', ['children'=>$children, 'dataProvider'=>$relatedDataProvider, 'specials'=>$specials] ) ?>
	
</div>


