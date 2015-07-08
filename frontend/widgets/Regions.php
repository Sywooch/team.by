<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\web\Cookie;

use common\models\Region;

class Regions extends Widget
{
    public $controller;
    public $action;


    public function init()
    {
        parent::init();
        if ($this->controller === null) $this->controller = 'site';
        if ($this->action === null) $this->action = 'index';		
    }

    public function run()
    {
		//получаем из куки ИД региона
		$region_id = \Yii::$app->getRequest()->getCookies()->getValue('region', 1);
		
		$Region = new Region();		
		$regions = $Region->getRegionsList($region_id);
		//echo'<pre>';print_r($regions_l1);echo'</pre>';	die;	
		
		return $this->render('regions', [
			'regions'=>$regions['list'],
			'region_id'=>$region_id,
			'region_str'=>$regions['active'],
		]);
    }
}