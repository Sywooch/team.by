<?php


$this->params['breadcrumbs'][] = ['label' => 'Каталог специалистов', 'url' => ['index']];

foreach($parents as $parent) {
	if($parent->id <> 1)
		$this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => ['category', 'category'=>$parent->path]];
}
$this->params['breadcrumbs'][] = $category->name;

?>

<div class="catalog-item">
	<div class="catalog-item__body">
		<div class="row clearfix">
			<div class="catalog-item_body_left">
2321321
			</div>
			<div class="catalog-item_body_right">
				<p class="catalog-category-list-item__ttl"><?= $model->fio;?></p>	
			</div>
			
		</div>
	</div>
</div>


