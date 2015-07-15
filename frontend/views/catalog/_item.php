<?php 
use yii\helpers\Url;
use yii\helpers\Html;



if($model->education != '')	{
	$education_arr = explode('<br />', nl2br($model->education));
}	else	{
	$education_arr = [];
}

	
?>

<div class="clearfix">
	<a class="catalog-category-list-item__avatar_cnt" href="<?= Url::home(true).Yii::$app->params['avatars-path'].'/'.$model->avatar?>" data-toggle="lightbox">
		<img class="catalog-category-list-item__avatar" src="<?= Url::home(true).Yii::$app->params['avatars-path'].'/thumb_'.$model->avatar?>" alt="">
	</a>

	<div class="catalog-category-list-item__info_cnt">
		<div class="catalog-category-list-item__info_row">
			<p class="catalog-category-list-item__ttl"><?= $model->fio;?></p>	
			<span class="catalog-category-list-item__rating">Рейтинг: 5 из 5</span>
			<img src="/images/profi-lbl.png" alt="profi-lbl" class="profi_lbl catalog-category-list-item__profi_lbl" />
		</div>
		<div class="catalog-category-list-item__info_row">
			<span class="catalog-category-list-item__price">Стоимость работ: <?= \Yii::$app->formatter->asDecimal($model->price); ?> руб.</span>
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
						<li>проектирование</li>
						<li>планировка</li>
						<li>установка</li>
						<li>разнорабочий</li>
						<li>облицовка</li>
						<li>выравнивание стен</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="catalog-category-list-item__info_row_bottom">
			<a href="#" class="catalog-category-list-item__reviews">Отзывы (45)</a>
			<a href="#" class="catalog-category-list-item__examples">Примеры работ (14)</a>
			
			<a href="<?= \Yii::$app->urlManager->createUrl(['catalog/show', 'id' => $model->id])?>" class="button-blue btn-short catalog-category-list-item__detail">Подробнее о специалисте</a>
			<a href="#" class="button-red btn-short catalog-category-list-item__contact">Связаться</a>
		</div>
	</div>
</div>