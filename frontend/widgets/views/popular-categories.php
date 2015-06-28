<?php
use yii\bootstrap\Nav;
?>


<div class="container">
	<span class="header_popular__ttl">Популярные категории</span>


	<?php 
	echo Nav::widget([
	'options' => [
	'class' => 'navbar-nav navbar-left header_navbar'
	],
	'items' => [
	'<li><a href="'. urldecode(\Yii::$app->urlManager->createUrl(['catalog/category', 'category' => 'mastera-po-remontu/santehniki'])).'" class="header_navbar__item"><span>Репетиторы</span>учителя и лекторы</a></li>',
	'<li><a href="#" class="header_navbar__item"><span>Артисты</span>певцы и ведущие</a></li>',
	'<li><a href="#" class="header_navbar__item"><span>Мастера красоты</span>учителя и ученики</a></li>',
	'<li><a href="#" class="header_navbar__item"><span>Фотографы</span>Свадебные съемки</a></li>',
	'<li><a href="#" class="header_navbar__item"><span>Спортивные тренеры</span>индивидуальные тренера</a></li>',
	]
	]);				   
	?>
</div>
