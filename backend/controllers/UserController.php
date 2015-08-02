<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use app\models\ChangePasswordForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->where(['group_id' => 1]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSpecs()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->where(['group_id' => 2])->andWhere('id > 0'),
        ]);

        return $this->render('specs', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
		$model->scenario = "create";
		
		$allRoles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
		$modelHasRoles = array_keys(Yii::$app->authManager->getRolesByUser($model->getId()));
		$request = Yii::$app->request;
		$name_of_role = $request->post('role_name'); 
		
		
		

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if($name_of_role != null) {
				$userRole = Yii::$app->authManager->getRole($name_of_role);
				Yii::$app->authManager->assign($userRole, $model->getId());					
			}			
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'allRoles' => $allRoles,
                'modelHasRoles' => $modelHasRoles,				
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		$allRoles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
		$modelHasRoles = array_keys(Yii::$app->authManager->getRolesByUser($model->getId()));
		$request = Yii::$app->request;
		$name_of_role = $request->post('role_name'); 

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if($name_of_role != null) {
				if(count($modelHasRoles) == 1 && $modelHasRoles[0] != $name_of_role) {
					Yii::$app->authManager->revokeAll($model->getId());	//Удалить все ранее привязанные роли пользователя
					//echo'<pre>';print_r($name_of_role);echo'</pre>';//die;
					//echo'<pre>';print_r($modelHasRoles);echo'</pre>';die;

					$userRole = Yii::$app->authManager->getRole($name_of_role);
					Yii::$app->authManager->assign($userRole, $model->getId());
				}
			}
			
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'allRoles' => $allRoles,
                'modelHasRoles' => $modelHasRoles,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
    public function actionChangePassword($id)
    {
        $user = $this->findModel($id);
        $model = new ChangePasswordForm($user);
 
        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('changePassword', [
                'model' => $model,
            ]);
        }
    }	

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
