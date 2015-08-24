<?php
namespace common\helpers;

class DCategoryHelper
{
    public static function prepareMainCategories(&$categories)
    { 
		$cat_ids = [];
		foreach($categories as $c){
			if($c->depth == 2) {
				$cat_ids[] = $c->id;
			}
		}
		
		$command = \Yii::$app->db->createCommand('SELECT `category_id`, count(`user_id`) AS count FROM {{%user_categories}} AS uc INNER JOIN {{%user}} AS u ON u.id = uc.user_id WHERE u.is_active = 1 AND u.`user_status` IN('.implode(',', \common\models\User::getActiveUserStatuses()).') AND `category_id` IN ('.implode(', ', $cat_ids).') GROUP BY `category_id`');
		$with_specs = $command->queryAll();
		//echo'<pre>';print_r($with_specs);echo'</pre>';
		
		$categories_n = [];
		foreach($categories as $k=>$c){
			if($c->depth == 2) {
				$is_delete = true;
				foreach($with_specs as $row) {
					if($row['category_id'] == $c->id) {
						$is_delete = false;
						break;
					}
				}
				
				if($is_delete === true)
					unset($categories[$k]);
					
			}
		}
    }
	
    public static function prepareCatalogCategories(&$children, $table)
    { 
		$command = \Yii::$app->db->createCommand('SELECT `category_id`, count(`user_id`) AS count FROM {{%'.$table.'}} AS uc INNER JOIN {{%user}} AS u ON u.id = uc.user_id WHERE u.is_active = 1 AND u.`user_status` IN('.implode(',', \common\models\User::getActiveUserStatuses()).') GROUP BY `category_id`');
		$with_specs = $command->queryAll();				

		$children_n = [];
		foreach($children as $child) {
			foreach($with_specs as $row) {
				if($row['category_id'] == $child->id) {
					$children_n[] = $child;
				}
			}
		}
		$children = $children_n;
    }
	
    public static function prepareMainCategoriesForView(&$categories)
    { 
		self:: prepareMainCategories($categories);
		
		$cats_l1 = [];

		foreach($categories as $c){
			if($c->parent_id == 1)	$cats_l1[] = [
				'id'=>$c->id,
				'name'=>$c->name,
				'alias'=>$c->alias,
				'path'=>$c->path,
				'children'=>[],
			];
		}		

		foreach($cats_l1 as &$c_l1){
			foreach($categories as $c){
				if($c->parent_id == $c_l1['id']) {
					$c_l1['children'][] = [
						'id'=>$c->id,
						'name'=>$c->name,
						'alias'=>$c->alias,
						'path'=>$c->path,
					];
				}
			}
		}
		
		$categories = $cats_l1;		
    }
}

