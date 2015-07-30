<?php
namespace backend\controllers;

use Yii;

use common\models\Order;

use backend\models\OrderSearch;

use frontend\helpers\DDateHelper;


class ShedulerController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionOrders($date)
    {
        //$date_unix = DDateHelper::DateToUnix($date, 2);
		//echo'<pre>';print_r(Yii::$app->request->queryParams);echo'</pre>';die;
		$searchModel = new OrderSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
        return $this->render('orders', [
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'date'=>$date,
        ]);
    }

}
