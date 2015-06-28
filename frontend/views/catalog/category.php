<?php
/* @var $this yii\web\View */
$this->title = $category->name .' | '. Yii::$app->params['sitename'];

//echo'<pre>';print_r(Yii::$app->params['sitename']);echo'</pre>';
?>


<h1><?= $category->name?></h1>