<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\web\Cookie;

//use yii\web\Controller;

use common\models\Region;

class Regions extends Widget
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
		//получаем из куки ИД региона
		$region_id = \Yii::$app->getRequest()->getCookies()->getValue('region', 1);
		
        //return Html::encode($this->message);
		$regions = Region::find()->where('id <> 1')->orderBy('lft, rgt')->all();
		
		$regions_l1 = [];
		
		$region_str = 'Вся Беларусь';
		
		//if($region_id != 1) {
//			$regions_l1[] = [
//				'id'=>1,
//				'name'=>$region_str,
//				'children'=>[],
//			];
			
		//}
		$region_active = false;

		foreach($regions as $row){
			$region_active = false;
			
			if($row->parent_id == 1) {
				
				if($row->id == $region_id) {
					$region_str = $row->name;
					$region_active = true;
				}
			
				$regions_l1[] = [
					'id'=>$row->id,
					'name'=>$row->name,
					'active'=>$region_active,
					'children'=>[],
				];
			}
		}		
		
		foreach($regions_l1 as &$row_l1){
			foreach($regions as $row){
				$region_active = false;
				
				if($row->parent_id == $row_l1['id']) {
					
					if($row->id == $region_id) {
						$region_str = $row->name;
						$region_active = true;
					}
					
					$row_l1['children'][] = [
						'id'=>$row->id,
						'name'=>$row->name,
						'active'=>$region_active,
					];
				}
			}
		}
		
		if($region_id == 1)	$region_active = true;
			else $region_active = false;
		
		$all_regions[] = [
			'id'=>1,
			'name'=>'Вся Беларусь',
			'active'=>$region_active,
			'children'=>[],
		];
			
		$regions_l1 = array_merge($all_regions, $regions_l1);
		
	//	echo'<pre>';print_r($regions_l1);echo'</pre>';	die;	
		
		return $this->render('regions', [
			'regions'=>$regions_l1,
			'region_id'=>$region_id,
			'region_str'=>$region_str,
		]);
    }
}