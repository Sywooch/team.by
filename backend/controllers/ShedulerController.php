<?php
namespace backend\controllers;

use Yii;

use common\models\Order;

use frontend\helpers\DDateHelper;


class ShedulerController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionOrders($date)
    {
        echo '////////////////////$date';
        echo $date;
		
		return $this->render('orders', [
			'date'=>$date,
		]);
    }

}
