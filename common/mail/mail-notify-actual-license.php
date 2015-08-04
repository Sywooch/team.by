<div>
	<p>Уважаемый <?= $model->fio?></p>
	<p><?= \Yii::$app->formatter->asDate($model->license_checked, 'php:d-m-yy') ?>  заканчивается срок действия лицензии. Необходимо предоставить актуальный документ</p>
</div>