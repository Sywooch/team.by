<?php

use yii\helpers\Url;

?>


<div class="row clearfix mb-30">
	<div class="col-lg-2">
		<p><?php echo Yii::$app->formatter->asDate($model->created_at, 'php:d M Y H:i'); ?></p>

	</div>
	<div class="col-lg-6">
		<p><?= nl2br($model->msg)?></p>
	</div>
	<div class="col-lg-2">
		<?php if($model->readed == 0)	{	?>
			<a href="<?= Url::to(['profile/set-readed-notify', 'id'=>$model->id])?>" class="button-blue">Прочитано</a>
		<?php	}	?>
	</div>
	<div class="col-lg-2">
		<a href="<?= Url::to(['profile/delete-notify', 'id'=>$model->id])?>" class="button-red">Удалить</a>
	</div>
</div>
