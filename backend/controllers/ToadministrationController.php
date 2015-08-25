<?php

namespace backend\controllers;

use Yii;
use common\models\UserToAdministration;

use backend\models\UserToAdministrationSearch;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ToadministrationController implements the CRUD actions for UserToAdministration model.
 */
class ToadministrationController extends Controller
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
     * Lists all UserToAdministration models.
     * @return mixed
     */
    public function actionIndex()
    {
		$this->chekUserAdminOrManager();
		
        $searchModel = new UserToAdministrationSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
        return $this->render('index', [
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserToAdministration model.
     * @param integer $id
     * @return mixed
     */
	/*
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
	*/

    /**
     * Creates a new UserToAdministration model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	/*
    public function actionCreate()
    {
        $this->chekUserAdminOrManager();
		
		$model = new UserToAdministration();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	*/
    /**
     * Updates an existing UserToAdministration model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->chekUserAdminOrManager();
		
		$model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			
			$model->save();
			
			//if($model->sendEmail('aldegtyarev@yandex.ru')) {
			if($model->sendEmail($model->user->email)) {
				Yii::$app->getSession()->setFlash('success', 'Ответ успешно отправлен');
				$model->status = 2;
				$model->save();
			}	else	{
				Yii::$app->getSession()->setFlash('error', 'При отправке сообщения возникла ошибка');
			}
			
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UserToAdministration model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->chekUserAdminOrManager();
		
		$this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserToAdministration model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserToAdministration the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserToAdministration::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
