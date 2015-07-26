<?php
use yii\widgets\ListView;
use yii\helpers\Html;
//use yii\helpers\Url;

?>

<div class="catalog-item__related">
	<p class="catalog-item__ttl">Искать других специалистов по услугам</p>
	
<?php if(count($children))	{	?>
	<div class="catalog-category-children__list">
		<ul class="row clearfixt">
			<?php foreach($children as $c)	echo Html::tag('li', Html::a(Html::encode($c->name), ['catalog/category', 'category' => $c->path]), ['class' => 'col-lg-2 catalog-category-children__item']) ?>
		</ul>
	</div>
<?php	}	?>
	
	
	<?php
	echo ListView::widget( [
		'dataProvider' => $dataProvider,
		'itemView' => '_item-related',
		'summary' => '',
		'id' => 'items-list',
		'options' => ['class' => 'list-view catalog-item__related_list row'],
		'itemOptions' => ['class'=>'catalog-item__related_item'],
		'layout' => '{items}',
		'viewParams'=> ['specials'=>$specials],
	] );
	?>
</div>