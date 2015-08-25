<?php

namespace backend\controllers;

use Yii;
use common\models\Review;
use backend\models\ReviewSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReviewController implements the CRUD actions for Review model.
 */
class ReviewController extends Controller
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
     * Lists all Review models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReviewSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Review model.
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
     * Creates a new Review model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Review();
		
		Yii::$app->session->set('profile_model', 'Review');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Review model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		//для коректной загрузки файлов аяксом
		//устанавливаем с какой моделью будем работать		
		Yii::$app->session->set('profile_model', 'Review');
		
		//$reviewMedia_old = [];
		$reviewMedia_old = $model->reviewMedia;
		
		
		
		//echo'<pre>';print_r($model);echo'</pre>';die;
        if ($model->load(Yii::$app->request->post())) {
			
			if($model->validate()) {
				$model->save();
				$this->checkReviewFoto($model, $reviewMedia_old);
				
				if($review->status == 1)
					$this->calculateRating($model);	
			}
			
			//echo'<pre>';print_r($reviewMedia_old);echo'</pre>';//die;
			//echo'<pre>';print_r($model);echo'</pre>';die;
			
            return $this->redirect(['index']);
        } else {
			foreach($model->reviewMedia as $item) $model->review_foto[] = $item->filename;
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Review model.
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
     * Finds the Review model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Review the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Review::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	//проверяем изменения в фото для отзывов
	public function checkReviewFoto($model, $reviewMedia_old)
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
				if($array_identical = false) break;
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
				$ReviewMedia->review_id = $model->id;
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
	
	public function calculateRating($order)
	{
		$user = $order->user;
		$user_reviews = $user->reviews;
		$total_rating = 0;
		foreach($user_reviews as $rewiew) {
			$total_rating += $rewiew->review_rating;
		}
		
		//echo'<pre>';print_r($total_rating);echo'</pre>';//die;
		//echo'<pre>';print_r(count($user_reviews));echo'</pre>';//die;
		
		
		$total_rating = $total_rating / count($user_reviews);
		
		$user->total_rating = $total_rating;
		//$user->total_rating = 4.7;
		
		$user->setMedalOfRating(count($user_reviews));
		//$user->setMedalOfRating(30);
		$user->save();
	}
	
	
}
