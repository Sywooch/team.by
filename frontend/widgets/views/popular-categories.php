<?php
use yii\bootstrap\Nav;

$items = [];
foreach($models as $model) {
	$items[] = '<li><a href="'. urldecode(\Yii::$app->urlManager->createUrl(['catalog/category', 'category' => $model['path']])).'" class="header_navbar__item"><span>'.$model['parent_name'].'</span>'.$model['name'].'</a></li>';
}
?>


<div class="container">
	<p class="header_popular__ttl_cnt">
		<span class="header_popular__ttl">Популярные категории</span>
	</p>


	<?php 
	echo Nav::widget([
		'options' => [
			'class' => 'navbar-nav navbar-left header_navbar'
		],
		'items' => $items,

			/*[
		'<li><a href="'. urldecode(\Yii::$app->urlManager->createUrl(['catalog/category', 'category' => 'mastera-po-remontu/santehniki'])).'" class="header_navbar__item"><span>Репетиторы</span>учителя и лекторы</a></li>',
		'<li><a href="#" class="header_navbar__item"><span>Артисты</span>певцы и ведущие</a></li>',
		'<li><a href="#" class="header_navbar__item"><span>Мастера красоты</span>учителя и ученики</a></li>',
		'<li><a href="#" class="header_navbar__item"><span>Фотографы</span>Свадебные съемки</a></li>',
		'<li><a href="#" class="header_navbar__item"><span>Спортивные тренеры</span>индивидуальные тренера</a></li>',
		]*/
	]);				   
	?>
</div>
