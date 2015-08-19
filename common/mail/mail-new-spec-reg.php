<?php
// шаблон отправки письма
?>


<div>
	<p>Уважаемый <?= $user['fio'] ?></p>
	<p>Вы зарегистрировались на сайте <a href="<?= Yii::$app->params['homeUrl']?>"><?= Yii::$app->params['sitename']?></a></p>
	<p>Для входа на сайт используйте следующие данные:</p>
	<p>E-mail: <?= $model['email']?></p>
	<p>Пароль: <?= $model['password']?></p>
</div>