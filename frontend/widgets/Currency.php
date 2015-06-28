<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class Currency extends Widget
{
    public $message;

    public function init()
    {
        parent::init();
//        if ($this->message === null) {
//            $this->message = 'Hello World';
//        }
    }

    public function run()
    {
		//получаем из куки ИД региона
		$currency_id = \Yii::$app->getRequest()->getCookies()->getValue('currency', 1);
		
		return $this->render('currency', [
			'currency_id'=>$currency_id,
		]);
    }
}