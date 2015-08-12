<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\RegStep1Form */
/* @var $form ActiveForm */

$this->title = \Yii::$app->params['sitename'] .' | ' . 'Завершить регистрацию';

?>
<div class="site-reg-final">
	<div class="site-reg-final__cnt">
		<p>После проверки ваших данных администратором информация о ваших услугах будет размещена на сайте, а вы получите ключи от своего личного кабинета на team.by</p>
		<p class="dinpro-b">Желаем успехов!</p>
		<p><a href="http://team.by" class="button-red">Завершить регистрацию</a></p>
	</div>
</div>
