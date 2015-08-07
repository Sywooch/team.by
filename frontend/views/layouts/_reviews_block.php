<?php

\frontend\assets\FormStylerAsset::register($this);
\frontend\assets\AjaxUploadAsset::register($this);
	
?>
<div class="reviews_block">
	<div class="container">
		<p class="h1 reviews_block__ttl">Отзывы о специалистах</p>
		<div class="reviews_block__cnt">
			У каждого нашего клиента мы запрашиваем отзыв о работе специалиста. Отзыв могут оставить только наши клиенты, поэтому все отзывы у нас настоящие. Отзывы клиентов публикуются без редактирования, как есть. Негативные отзывы не удаляются.
		</div>
		<?/*<a href="#" class="button-red reviews_block__send">Оставить отзыв о специалисте</a>*/?>
		<span id="add_review" class="button-red1 reviews_block__send" data-review="<?= \Yii::$app->urlManager->createUrl(['site/new-review']) ?>">Оставить отзыв о специалисте</span>
	</div>
</div>
