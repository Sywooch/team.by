<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

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
		
		return $this->render('profile-header');
    }
}