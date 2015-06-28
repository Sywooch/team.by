<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class PopularCategories extends Widget
{
    public $message;

    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = 'Hello World';
        }
    }

    public function run()
    {
        //return Html::encode($this->message);
		return $this->render('popular-categories', [
			'message'=>$this->message,
		]);
    }
}