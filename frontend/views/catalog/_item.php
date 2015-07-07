<?php 
use yii\helpers\Url;




	
	
?>

<div class="row clearfix">
	<div class="col-lg-4">
		<a href="<?= Url::home(true).Yii::$app->params['avatars-path'].'/'.$model->avatar?>" data-toggle="lightbox">
			<img class="catalog-category-list-item__avatar" src="<?= Url::home(true).Yii::$app->params['avatars-path'].'/thumb_'.$model->avatar?>" alt="">
		</a>
	</div>
	<div class="col-lg-8">
		<p><?= $model->fio;?></p>
	</div>
</div>