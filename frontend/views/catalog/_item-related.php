<?php

use yii\helpers\Html;

//echo'<pre>';print_r($model);echo'</pre>';

$userSpecials1 = $userSpecials2 = [];
$i = 0;
foreach($model->userSpecials as $spec) {
	if(isset($specials[$spec->category_id]))	{
		if($i <= 4) {
			$userSpecials1[] = $specials[$spec->category_id];
		}	else	{
			$userSpecials2[] = $specials[$spec->category_id];
		}
		$i++;
		
	}
		
}


?>

<div class="catalog-item__related_item_cnt">
	<div class="related_item__r1">
		<a href="<?= $model->frontendUrl ?>" class="related_item__avatar" title="<?= $model->fio?>">
			<img src="<?= $model->avatarThumbUrl ?>" class="img-responsive" alt="<?= $model->fio?>">
		</a>
		<p class="related_item__rating">
			Рейтинг: <?= $model->total_rating?>
			<?php echo $model->medalImage ?>
			<?php 
				//if($model->total_rating == 5) echo Html::img('/images/profi-gold.png', ['alt'=>'Супер профи', 'title'=>'Супер профи', 'class'=>'profi_lbl related_item__profi_lbl']);
				//if($model->total_rating >= 4) echo Html::img('/images/profi-silver.png', ['alt'=>'Профи', 'title'=>'Профи', 'class'=>'profi_lbl related_item__profi_lbl']);
			?>			
		</p>
		<a href="<?= $model->frontendUrl ?>" class="related_item__name" title="<?= $model->fio?>"><?= $model->fio?></a>
	</div>
	
	<div class="related_item__r2">
		<p class="related_item__r2_ttl">
			<span class="bold">Виды услуг:</span>
			<?php if(count($userSpecials2))	{	?>
				<a href="#" class="showmorespecials-btn catalog-category-list-item__examples" data-spec="<?= $model->id ?>">Все услуги</a>						
			<?php	}	?>							
		
		</p>
		
		<ul class="related_item__uslugi">
			<?php foreach($userSpecials1 as $spec) echo Html::tag('li', $spec); ?>
		</ul>
		<?php if(count($userSpecials2))	{	?>
			<ul id="uslugi-list-<?= $model->id ?>" class="related_item__uslugi catalog-category-list-item__uslugi-add">
				<?php foreach($userSpecials2 as $spec) echo Html::tag('li', $spec); ?>
			</ul>
		<?php	}	?>
		
		<?/*
		<ul class="related_item__uslugi">
			<?php 
				foreach($model->userSpecials as $spec) {
					if(isset($specials[$spec->category_id])) echo Html::tag('li', $specials[$spec->category_id]);
				}
			?>
		</ul>
		*/?>
	</div>
</div>