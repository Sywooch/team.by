<?php

namespace backend\controllers;

use Yii;
use common\models\Order;
use common\models\OrderStatusHistory;

use backend\models\OrderForm;
use backend\models\OrderSearch;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use frontend\helpers\DDateHelper;

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
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
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
				
				$order = new \common\models\Order();

				$model_attribs = $model->toArray();
				$order_attr = $order->attributes;

				foreach($order_attr as $attr_key=>&$attr)	{
					if(isset($model_attribs[$attr_key]))
						$order->$attr_key = $model_attribs[$attr_key];
				}
				
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
						//echo'<pre>';print_r($client);echo'</pre>';die;
						
						$order->client_id = $client->id;
						
						//$model->addError()
					}
				}				
								
				//обрабатываем дату в корректный вид
				if($order->date_control == '') {
					$order->date_control = time();
				}	else	{
					$order->date_control = DDateHelper::DateToUnix($order->date_control, 2);
				}
				//echo'<pre>';var_dump($order);echo'</pre>';die;

				if($order->payment_date == '') {
					$order->payment_date = (string) time();
				}	else	{
					$order->payment_date = (string) DDateHelper::DateToUnix($order->payment_date, 2);
				}
				//echo'<pre>';var_dump($order);echo'</pre>';die;

				$order->save();
				echo'<pre>';print_r($order);echo'</pre>';die;				
				
				//сохраняем статус и истории статусов
				$this->addStatusToHistory($order);
				
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
        $order = $this->findModel($id);
		//echo $_SERVER['DOCUMENT_ROOT'];
		
		$model = new OrderForm();
		
		$model->attributes = $order->toArray();
		$model->order_id = $order->id;
		
		$reviewMedia_old = [];
		//echo'<pre>';var_dump($order->review);echo'</pre>';die;
		
		//загружаем информацию по отзыву
		if($order->review !== NULL)	{
			$model->review_text = $order->review->review_text;
			$model->review_rating = $order->review->review_rating;
			$model->review_state = $order->review->status;
			$model->answer_text = $order->review->answer_text;
			$model->answer_status = $order->review->answer_status;
			
			if($order->review->reviewMedia !== NULL)	{
				//получаем загруженные фото к отзыву
				$reviewMedia_old = $order->review->reviewMedia;
				
			}
		}
		
		
		
		if(isset($_POST['OrderForm']))	{
			$model->load(Yii::$app->request->post());
			
			if($model->review_text != '')
				$model->scenario = 'add_rating';

			if ($model->validate()) {
								
				//обрабатываем дату в корректный вид
				if($model->date_control != '00-00-0000') {
					$model->date_control = DDateHelper::DateToUnix($model->date_control, 2);
				}	else	{
					$model->date_control = null;
				}
				//echo'<pre>';var_dump($model->payment_date);echo'</pre>';die;
				if($model->payment_date != '00-00-0000' && $model->payment_date != '') {
					$model->payment_date = (string) DDateHelper::DateToUnix($model->payment_date, 2);
				}	else	{
					$model->payment_date = '';
				}
				
				//echo'<pre>';print_r($model);echo'</pre>';die;
				$model_attribs = $model->toArray();
				$order_attr = $order->attributes;

				foreach($order_attr as $attr_key=>&$attr)	{
					if(isset($model_attribs[$attr_key]))
						$order->$attr_key = $model_attribs[$attr_key];
				}
				
				if($order->oldAttributes['status'] != $order->status) {
					//сохраняем статус и истории статусов
					$this->addStatusToHistory($order);
				}
				//echo'<pre>';print_r($order->oldAttributes['status']);echo'</pre>';die;
				
				$order->save();
				//echo'<pre>';print_r($order);echo'</pre>';die;
				
				
				
				if($model->review_text != '')	{
					//если отзыв уже имеется то загружаем его
					if($order->review === NULL)	{
						$review = new \common\models\Review();
					}	else	{
						$review = \common\models\Review::findOne($order->review->id);
					}
					
					$review_attr = $review->attributes;
					
					foreach($review_attr as $attr_key=>&$attr)	{
						if(isset($model_attribs[$attr_key]))
							$review->$attr_key = $model_attribs[$attr_key];
					}
					
					$review->status = $model->review_state;
					$review->save();
					
					//echo'<pre>';print_r($review);echo'</pre>';die;
					$this->checkReviewFoto($model, $reviewMedia_old, $review->id);
					
					$this->setRatingTotalForUser($review->user_id);
				}
				
				//echo'<pre>';print_r(Yii::getAlias('@frontend'));echo'</pre>';die;
				//echo'<pre>';print_r($model);echo'</pre>';die;
				return $this->redirect(['index']);
			}
		}
		//echo'<pre>';print_r($model->date_control);echo'</pre>';//die;
		if($model->date_control) {
			$model->date_control = Yii::$app->formatter->asDate($model->date_control, 'php:d-m-yy');
		}	else	{
			$model->date_control = '00-00-0000';
		}
		//echo'<pre>';print_r($model->date_control);echo'</pre>';die;
		
		if($model->payment_date) {
			$model->payment_date = Yii::$app->formatter->asDate($model->payment_date, 'php:d-m-yy');
		}	else	{
			$model->payment_date = '00-00-0000';
		}
		

		//загружаем информацию по отзыву
		if($order->review !== NULL)	{
			if($order->review->reviewMedia !== NULL)	{
				//получаем загруженные фото к отзыву
				foreach($order->review->reviewMedia as $item)	$model->review_foto[] = $item->filename;
			}
		}
		//echo'<pre>';print_r($model->date_control);echo'</pre>';die;
		return $this->render('update', [
			'model' => $model,
			'orderStatusHistories' => $order->orderStatusHistories,
		]);
        
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
	
	//проверяем изменения в фото для отзывов
	public function checkReviewFoto($model, $reviewMedia_old, $review_id)
	{
		$array_identical = false;
		
		if(count($model->review_foto) != count($reviewMedia_old)) {
			$array_identical = false;
		}	else	{
			foreach($reviewMedia_old as $item)	{
				$array_identical = false;
				foreach($model->review_foto as $item1)	{
					if($item->filename == $item1)
						$array_identical = true;
				}
			}
		}
		
		//echo'<pre>';var_dump($array_identical);echo'</pre>';//die;
		//echo'<pre>';print_r($model->review_foto);echo'</pre>';//die;
		//echo'<pre>';print_r($reviewMedia_old);echo'</pre>';die;
		
		if($array_identical == false) {
			foreach($reviewMedia_old as $item)	{
				//перемещаем фото в temp
				if(file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['reviews-path'].'/'.$item->filename))
					rename(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['reviews-path'].'/'.$item->filename, Yii::getAlias('@frontend').'/web/tmp/'.$item->filename);

				if(file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['reviews-path'].'/thumb_'.$item->filename))
					rename(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['reviews-path'].'/'.'thumb_'.$item->filename, Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$item->filename);

				$item->delete();
			}

			foreach($model->review_foto as $foto) {
				$ReviewMedia = new \common\models\ReviewMedia();
				$ReviewMedia->review_id = $review_id;
				$ReviewMedia->filename = $foto;
				if($ReviewMedia->save())	{
					//перемещаем фото
					if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.$foto))
						rename(Yii::getAlias('@frontend').'/web/tmp/'.$foto, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['reviews-path'].'/'.$foto);

					if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$foto))
						rename(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$foto, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['reviews-path'].'/'.'thumb_'.$foto);
				}
			}
		}
	}
	
	//пересчитыват рейтинг пользователя
	public function setRatingTotalForUser($user_id)
	{
		$user = \common\models\User::findOne($user_id);
		if($user !== null) {
			$rating_total = 0;
			foreach($user->reviews as $review) $rating_total += $review->review_rating;
			$user->total_rating = $rating_total / count($user->reviews);
			$user->save();
		}
	}
	
	public function addStatusToHistory($order)
	{
		$OrderStatusHistory = new OrderStatusHistory();
		$OrderStatusHistory->order_id = $order->id;
		$OrderStatusHistory->status_id = $order->status;
		$OrderStatusHistory->save();
		//echo'<pre>';print_r($OrderStatusHistory);echo'</pre>';die;
		
	}
}
