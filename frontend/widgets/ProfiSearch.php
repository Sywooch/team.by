<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class ProfiSearch extends Widget
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
		return $this->render('profi_search', [
			'message'=>$this->message,
		]);
    }
}