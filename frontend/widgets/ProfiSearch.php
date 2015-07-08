<?php

namespace frontend\widgets;

use yii\base\Widget;
use common\models\Region;

class ProfiSearch extends Widget
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
		if($this->controller == 'site' && $this->action == 'index')	{
			$view = 'profi_search';
		}	else	{
			$view = 'profi_search_inner';
		}
		
		if(($this->controller == 'site' && $this->action == 'index') || ($this->controller == 'catalog'))	{
			
			//получаем из куки ИД региона
			$region_id = \Yii::$app->getRequest()->getCookies()->getValue('region', 1);
			
			$Region = new Region();		
			$regions = $Region->getRegionsList($region_id);
			
			return $this->render($view, [
				'regions'=>$regions['list'],
				'region_id'=>$region_id,
				'region_str'=>$regions['active'],
				
			]);
		}	else	{
			return;
		}

    }
}