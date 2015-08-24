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
		
		//получаем из куки ИД региона
		$region_id = \Yii::$app->getRequest()->getCookies()->getValue('region', 1);
		
		$region_id_get = \Yii::$app->request->get('region_id', 0);
		
		if($region_id_get > 0)
			$region_id = $region_id_get;
			
		$Region = new Region();
		$regions = $Region->getRegionsList($region_id);
		
		if(($this->controller == 'site' && $this->action == 'index') || ($this->controller == 'catalog'))	{			
			
			
			if($this->controller == 'site' && $this->action == 'index')	{
				$view = 'profi_search';
				$categories = [];

				$data = [
					'search_qry'=>\Yii::$app->request->get('profi_search', ''),
					'regions'=>$regions['list'],
					'region_str'=>$regions['active'],
					'region_id'=>$region_id,
					'region_str'=>$regions['active'],
					'model'=> new \frontend\models\ZakazSpec1(),
				];

			}	else	{
				$view = 'profi_search_inner';
				$categories = \common\models\Category::find()->where('id <> 1 AND depth < 3')->orderBy('lft, rgt')->all();
				
				\common\helpers\DCategoryHelper::prepareMainCategoriesForView($categories);

				//var_dump($categories);die;
				
				
				$data = [
					'search_qry'=>\Yii::$app->request->get('profi_search', ''),
					'regions'=>$regions['list'],
					'region_id'=>$region_id,
					'region_str'=>$regions['active'],
					'categories'=>$categories,
					'controller'=>$this->controller,
					'action'=>$this->action
				];

			}
			
			
			return $this->render($view, $data);
		}	else	{
			return;
		}

    }
}