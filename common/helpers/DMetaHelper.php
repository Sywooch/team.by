<?php
namespace common\helpers;


class DMetaHelper
{
    public static function setMeta($model, &$cntr, $meta_title = '')
    {
		if($meta_title == '') {
			if($model->meta_title != '') $cntr->title = \Yii::$app->params['sitename'] .' | ' . $model->meta_title;
				else $cntr->title = \Yii::$app->params['sitename'] .' | ' . $model->name;			
		}	else	{
			$cntr->title = $meta_title;
		}

		if($model->meta_descr != '') $val = $model->meta_descr;
			else $val = $model->name;
				
		$cntr->registerMetaTag([
			'name' => 'description',
			'content' => $val,
		]);				

		if($model->meta_keyword != '') $val = $model->meta_keyword;
			else $val = $model->name;
				
				
			$cntr->registerMetaTag([
				'name' => 'keywords',
				'keyword' => $val,
			]);
    }
}

