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

		if($model->meta_descr != '') $cntr->registerMetaTag(['description' => $model->meta_descr]);
			else $cntr->registerMetaTag(['description' => $model->name]);

		if($model->meta_keyword != '') $cntr->registerMetaTag(['keyword' => $model->meta_keyword]);
			else $cntr->registerMetaTag(['keyword' => $model->name]);
    }
}

