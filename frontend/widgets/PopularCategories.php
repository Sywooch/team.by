<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

//use yii\helpers\ArrayHelper;
use common\models\Category;

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
        $models = Category::find()
			->asArray()
			->where(['popular' => 1])
			->limit(6)
			->all();
		
		//echo'<pre>';print_r($models);echo'</pre>';die;
		
		
		$ids_arr = [];
		foreach($models as $model) $ids_arr[] = $model['parent_id'];
			
		$parents = Category::find()
			->asArray()
			->where('id IN ('. implode(',', $ids_arr) . ')')
			->all();
		
		foreach($models as &$model) {
			foreach($parents as $parent) {
				if($parent['id'] == $model['parent_id']) $model['parent_name'] = $parent['name'];
			}
		}
		
		//echo'<pre>';print_r($ids_arr);echo'</pre>';//die;		
		//echo'<pre>';print_r($models);echo'</pre>';die;		
					  
		return $this->render('popular-categories', [
			'models' => $models,
		]);
    }
}