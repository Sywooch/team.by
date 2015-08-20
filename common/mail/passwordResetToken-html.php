<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->params['proUrl'] . Yii::$app->urlManager->createUrl(['site/reset-password', 'token' => $user->password_reset_token]);

?>
<div class="password-reset">
    <p>Здравствуйте, <?= Html::encode($user->username) ?></p>

    <p>Для сброса пароля перейдите по ссылке:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
