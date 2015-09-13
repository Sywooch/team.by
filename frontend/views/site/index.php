<?php
/* @var $this yii\web\View */
$this->title = Yii::$app->params['sitename'];

//echo'<pre>';print_r(Yii::$app->params['sitename']);echo'</pre>';
?>
<div class="site-index">
	<p class="h1">Все профессионалы</p>

    <div class="body-content">
       <?= $this->render('@app/views/catalog/_categories-list.php', ['categories' => $categories]) ?>
       
       	<?/*
        <p class="all_cats_show__cnt">
        	<a href="<?= urldecode(\Yii::$app->urlManager->createUrl(['catalog/index']))?>" class="button-blue all_cats_show">Показать все категории</a>
        </p>
		*/?>

    </div>
</div>
