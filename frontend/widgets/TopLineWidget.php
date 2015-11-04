<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

use common\models\Page;

/*
* виджет выводит текст в топ-лайне
1330-1758-7186-7233-3835-3314
*/

class TopLineWidget extends Widget
{
    public $page_id = 12;   //ИД материала
    
    public function init()
    {
        parent::init();
    }

    public function run()
    {
		if (\Yii::$app->user->isGuest) 
			return;
		
		return $this->render('top-line', [
			'model' => Page::findOne($this->page_id),
		]);
    }
}