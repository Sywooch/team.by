<?php
use yii\helpers\Url;
use yii\helpers\Html;

?>


<div class="catalog-category-list-item__info_row">
	<p class="catalog-category-list-item__ttl"><?= $model->fio;?></p>	
	<span class="catalog-category-list-item__rating">Рейтинг: <?=\Yii::$app->formatter->asDecimal($model->total_rating) ?> из 5</span>
	<?php 
		if($model->total_rating == 5) echo Html::img('/images/profi-gold.png', ['alt'=>'Супер профи', 'title'=>'Супер профи', 'class'=>'profi_lbl catalog-category-list-item__profi_lbl']);
		if($model->total_rating >= 4) echo Html::img('/images/profi-silver.png', ['alt'=>'Профи', 'title'=>'Профи', 'class'=>'profi_lbl catalog-category-list-item__profi_lbl']);
	?>
</div>
