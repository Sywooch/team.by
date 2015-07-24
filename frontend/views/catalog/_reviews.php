<?php
use yii\helpers\Html;
use yii\helpers\Url;

$review_item = 1;

?>


<div class="catalog-item__reviews">
	<?// echo'<pre>';print_r($model->reviews->limit(1));echo'</pre>'; ?>
	
	<?php if(count($model->reviews))	{	?>
		<p class="catalog-item__ttl">Отзывы клиентов (<?= count($model->reviews) ?>)</p>
		<ul class="reviews_list">
			<?php	foreach($model->reviews as $review)	{	?>
				<li class="reviews_item">
					<? echo $this->render('_review-item', ['model'=>$review])?>
				</li>

				<?php
					$review_item++;
					if($review_item > 3) break;
				?>
			<?php	}	?>


		</ul>
	<?php	}	else	{	?>
		<p class="catalog-item__ttl">Отзывы клиентов</p>
		<p class="mb-30">Отзывы о данном специалисте отсутствуют.</p>
	<?php	}	?>

	<div class="catalog-item__reviews_bottom">
		<a href="#" id="catalog-item__add_review" class="button-red catalog-item__add_review">Добавить свой отзыв</a>
		
		<?php if(count($model->reviews))	{	?>
			<a href="<?= \Yii::$app->urlManager->createUrl(['reviews/user', 'id' => $model->id]) ?>" id="catalog-item__show_reviews" class="button-blue catalog-item__show_reviews">Остальные отзывы</a>
		<?php	}	?>
	</div>
</div>
