<?php
namespace frontend\helpers;

use common\models\Currency;



class DPriceHelper
{
    public static function formatPrice($price = 0, $currency_id = 0)
    { 
        if($currency_id == 0)
			$currency_id = \Yii::$app->getRequest()->getCookies()->getValue('currency', 1);
		
		$model = Currency::findOne($currency_id);
		//echo'<pre>';print_r($currency_id);echo'</pre>';//die;

		if($model !== null ) {
			//echo ($price / $model->rate);
			$price = \Yii::$app->formatter->asDecimal(($price / $model->rate), (int)$model->decimals) . ' ' . $model->char_code;
		}	else	{
			$price = \Yii::$app->formatter->asDecimal($price) . ' руб.';
		}
		
		return $price;
    }
}

