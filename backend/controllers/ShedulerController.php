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
        $this->chekUserAdminOrManager();
		
		return $this->render('index');
    }

    public function actionOrders($date)
    {
        $this->chekUserAdminOrManager();
		
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
	
    public function chekUserAdminOrManager()
    {
		if (\Yii::$app->user->isGuest) {
			return $this->redirect('site/login'); 
		}
		
        $user = \common\models\User::findOne(Yii::$app->user->id);
		
		if($user->group_id != 1) {
			throw new \yii\web\ForbiddenHttpException('У вас нет доступа к данной странице');
		}
    }
	

}
