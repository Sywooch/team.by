<?php
use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\ListView;
?>
	

<div class="row clearfix">
	<div class="col-lg-4 clearfix">
		<div class="reviews_item__value_cnt">
			<p class="reviews_item__value"><?= $model->review_rating ?><span>оценка</span></p>
		</div>

		<div class="reviews_item__created_cnt">
			<p class="reviews_item__created"><?php echo Yii::$app->formatter->asDate($model->created_at, 'php:d M Y'); ?></p>
			<p class="reviews_item__name"><?=$model->client->fio?></p>
			<p><?= nl2br($model->client->info)?></p>
		</div>
	</div>
	<div class="col-lg-8">
		<div class="reviews_item__text_cnt">
			<div class="reviews_item__review_text"><?= $model->review_text ?></div>
			<div class="reviews_item__review_foto">
				<ul class="reviews_item__foto_list">
					
					<?php foreach($model->reviewMedia as $media) echo Html::tag('li', Html::a(Html::img(Url::home(true) . Yii::$app->params['reviews-path'] . '/thumb_' .$media->filename), Url::home(true) . Yii::$app->params['reviews-path'] . '/' .$media->filename, ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'review-images-'.$model->id]), ['class'=>'reviews_item__foto_item']); ?>
					<?php //echo Html::tag('li', Html::a(Html::img('http://placehold.it/70x42'), 'http://placehold.it/800x600', ['data-toggle'=>'lightbox', 'data-gallery'=>'review-1-images']), ['class'=>'reviews_item__foto_item']); ?>
					<?php //echo Html::tag('li', Html::a(Html::img('http://placehold.it/70x42'), 'http://placehold.it/800x600', ['data-toggle'=>'lightbox', 'data-gallery'=>'review-1-images']), ['class'=>'reviews_item__foto_item']); ?>
					<?php //echo Html::tag('li', Html::a(Html::img('http://placehold.it/70x42'), 'http://placehold.it/800x600', ['data-toggle'=>'lightbox', 'data-gallery'=>'review-1-images']), ['class'=>'reviews_item__foto_item']); ?>
				</ul>
			</div>
		</div>
	</div>
</div>
