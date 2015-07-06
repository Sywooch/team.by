<?php
/* @var $this yii\web\View */
$this->title = $category->name .' | '. Yii::$app->params['sitename'];

//echo'<pre>';print_r($parents);echo'</pre>';

//$this->params['breadcrumbs'][] = ['label' => 'Regions', 'url' => ['index']];

$this->params['breadcrumbs'][] = ['label' => 'Каталог специалистов', 'url' => ['index']];

foreach($parents as $parent) {
	if($parent->id <> 1)
		$this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => ['category', 'category'=>$parent->path]];
}
$this->params['breadcrumbs'][] = $category->name;

?>


<h1><?= $category->name?></h1>