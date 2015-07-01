<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\RegStep1Form */
/* @var $form ActiveForm */
?>
<div class="site-reg-final">
	<div class="site-reg-final__cnt">
		<p>После проверки ваших данных администратором информация о ваших услугах будет размещена на сайте, а вы получите ключи от своего личного кабинета на team.by</p>
		<p class="dinpro-b">Желаем успехов!</p>
		<p><a href="<?php echo Yii::$app->params['homeUrl']; ?>" class="button-red">Завершить регистрацию</a></p>
	</div>
</div>
