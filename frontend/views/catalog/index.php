<?php
/* @var $this yii\web\View */
$this->title = 'Все профессионалы';

//echo'<pre>';print_r($categories);echo'</pre>';
?>
<div class="site-index">
	<p class="h1">Все профессионалы</p>

    <div class="body-content">
       <?= $this->render('_categories-list', ['categories' => $categories]) ?>
    </div>
</div>
