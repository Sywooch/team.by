<?php
/* @var $this yii\web\View */
$this->title = 'Каталог специалистов';

//echo'<pre>';print_r($categories);echo'</pre>';
//$this->params['breadcrumbs'][] = ['label' => 'Regions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-index">
	<p class="h1">Каталог специалистов</p>

    <div class="body-content">
       <?= $this->render('_categories-list', ['categories' => $categories]) ?>
    </div>
</div>
