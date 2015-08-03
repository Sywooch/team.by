<?php

namespace backend\controllers;

use Yii;
use common\models\Notify;

use backend\models\NotifyForm;

use backend\models\NotifySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserNotifyController implements the CRUD actions for UserNotify model.
 */
class NotifyController extends Controller
{
    public function behaviors()
    {
        return [
			/*
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
			*/
        ];
    }

    /**
     * Lists all UserNotify models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NotifySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserNotify model.
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
     * Creates a new UserNotify model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserNotify();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UserNotify model.
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
     * Deletes an existing UserNotify model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionToSpec()
    {
		$user_ids = Yii::$app->request->post('user-ids', []);
		//echo'<pre>';print_r($user_ids);echo'</pre>';die;
		//echo'<pre>';print_r($_POST);echo'</pre>';die;
		if(count($user_ids) == 0) {
			\Yii::$app->session->setFlash('error', 'Отметьте получателей уведомления');
			return $this->redirect(['spec/index']);
		}
		
		$model = new NotifyForm();
		$model->user_ids = $user_ids;


		//return $this->redirect(['index']);
		return $this->render('to-spec', [
			'model' => $model,
			//'user_ids' => $user_ids,
		]);
		
    }
	
    public function actionToSpecAdd()
    {
		$model = new NotifyForm();
		
		if ($model->load(Yii::$app->request->post()) ) {
			//echo'<pre>';print_r($model);echo'</pre>';die;
			if(count($model->user_ids)) {
				foreach($model->user_ids as $user_id) {
					$notify = new Notify();
					$notify->user_id = $user_id;
					$notify->msg = $model->msg;
					$notify->save();
					//echo'<pre>';print_r($notify);echo'</pre>';die;
				}
			}
			
			\Yii::$app->session->setFlash('success', 'Уведомления отправлены');
			return $this->redirect(['/spec/index']);
			
		}
		
		return $this->render('to-spec', [
			'model' => $model,
			//'user_ids' => $user_ids,
		]);
		
	}

    /**
     * Finds the UserNotify model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserNotify the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserNotify::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
