<?php

namespace backend\controllers;

use Yii;
use common\models\Order;

use backend\models\OrderForm;
use backend\models\OrderSearch;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
		$dataProvider = new ActiveDataProvider([
            'query' => Order::find()->with('client'),
        ]);

        return $this->render('index', [
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrderForm();
		
		if(isset($_POST['OrderForm']))	{
			//echo'<pre>';print_r(Yii::$app->request->post('OrderForm'));echo'</pre>';die;
			$model->load(Yii::$app->request->post());
			if($model->client_id == 0)
				$model->scenario = 'create';
		
			if ($model->validate()) {
				if($model->client_id == 0) {
					$client = new \common\models\Client();
					$client->fio = $model->fio;
					$client->phone = $model->phone;
					$client->email = $model->email;
					$client->info = $model->info;
					
					if(!$client->save()) {
						$model->scenario = ''; //выключаем сценарий
						return $this->render('create', [
							'model' => $model,
						]);
						
						
						
					}	else	{
						$order->client_id = $client->id;
						//echo'<pre>';print_r($client);echo'</pre>';die;
						//$model->addError()
					}
				}
				
				$order = new \common\models\Order();

				$model_attribs = $model->toArray();
				$order_attr = $order->attributes;

				foreach($order_attr as $attr_key=>&$attr)	{
					if(isset($model_attribs[$attr_key]))
						$order->$attr_key = $model_attribs[$attr_key];
				}

				$order->save();
				return $this->redirect(['index']);				
			}
        }
		
		$model->scenario = ''; //выключаем сценарий
		return $this->render('create', [
			'model' => $model,
		]);
       
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
