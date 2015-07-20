<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

use common\models\User;

class ProfileHeader extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
		if (\Yii::$app->user->isGuest) 
			return;
		
		return $this->render('profile-header', ['model' => User::findOne(\Yii::$app->user->id)]);
    }
}