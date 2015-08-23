<?php

namespace backend\controllers;

use Yii;

//use backend\models\User;
use common\models\User;
use backend\models\UserSearch;

use backend\models\SpecForm;

use app\models\ChangePasswordForm;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use frontend\helpers\DDateHelper;

/**
 * UserController implements the CRUD actions for User model.
 */
class SpecController extends Controller
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
//        $dataProvider = new ActiveDataProvider([
//            'query' => User::find()->where(['group_id' => 2])->andWhere('id > 0'),
//        ]);
//
//        return $this->render('index', [
//            'dataProvider' => $dataProvider,
//        ]);
		
        $searchModel = new UserSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
        return $this->render('index', [
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
		
    }
    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	/*
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
	*/
	
	
    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
//		$allRoles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
//		$modelHasRoles = array_keys(Yii::$app->authManager->getRolesByUser($model->getId()));
//		$request = Yii::$app->request;
//		$name_of_role = $request->post('role_name'); 

        if ($model->load(Yii::$app->request->post())) {
			//echo'<pre>';print_r($model->license_checked);echo'</pre>';//die;
			if($model->license_checked)
				$model->license_checked = (string) DDateHelper::DateToUnix($model->license_checked, 2);
			
			$model->save();
			//echo'<pre>';print_r($model);echo'</pre>';die;
            return $this->redirect(['index']);
        } else {
			
			foreach($model->userRegions as $k=>$item)	{
				$model->regions[] = $item->region_id;
				$model->ratios[$k] = $item->ratio;
			}
			
			
			if($model->license_checked) {
				$model->license_checked = Yii::$app->formatter->asDate($model->license_checked, 'php:d-m-yy');
			}	else	{
				$model->license_checked = Yii::$app->formatter->asDate(time(), 'php:d-m-yy');
			}
			
			$user = $model;
			switch($user->user_type) {
				case 1:
					$document_form = 'DocumentsForm1';
					$document_form = new \frontend\models\DocumentsForm1();

					$document_form->passport_num = $user->passport_num;
					$document_form->passport_vidan = $user->passport_vidan;
					$document_form->passport_expire = $user->passport_expire;



					foreach($user->userDocuments as $doc) {
						switch($doc->document_id) {
							case 1:
								$document_form->passport_file = $doc->filename;
								break;
							case 2:
								$document_form->trud_file = $doc->filename;
								break;
							case 3:
								$document_form->diplom_file = $doc->filename;
								break;
							case 4:
								$document_form->other_file[] = $doc->filename;
								break;
						}
					}
					break;
				case 2:
					$document_form = 'DocumentsForm2';
					$document_form = new \frontend\models\DocumentsForm2();

					$user_attr = $user->attributes;
					foreach($user_attr as $attr_key=>$attr)	{					
						if(isset($document_form->$attr_key))
							$document_form->$attr_key = $user->$attr_key;
					}

					if($document_form->contact_phone == '')
						$document_form->contact_phone = '+375';

					foreach($user->userDocuments as $doc) {
						switch($doc->document_id) {
							case 5:
								$document_form->reg_file = $doc->filename;
								break;
							case 6:
								$document_form->bitovie_file = $doc->filename;
								break;
							case 7:
								$document_form->attestat_file = $doc->filename;
								break;
						}
					}


					$tmpl = 'documents-2';
					break;
				case 3:
					$document_form = 'DocumentsForm3';

					$document_form = new \frontend\models\DocumentsForm3();
					$document_form->license = $user->license;

					foreach($user->userDocuments as $doc) {
						switch($doc->document_id) {
							case 4:
								$document_form->other_file[] = $doc->filename;
								break;
							case 5:
								$document_form->reg_file = $doc->filename;
								break;
							case 6:
								$document_form->bitovie_file = $doc->filename;
								break;
						}
					}

					$tmpl = 'documents-3';
					break;
			}
			
			
            return $this->render('update', [
                'model' => $model,
				'document_form' => $document_form,
                //'allRoles' => $allRoles,
                //'modelHasRoles' => $modelHasRoles,
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
        $model = $this->findModel($id);
		
		//echo'<pre>';print_r($model->userMedia);echo'</pre>';die;
		foreach($model->userMedia as $media) {
			switch($media->media_id) {
				case 1:
					$path = Yii::getAlias('@frontend').'/web/'.Yii::$app->params['awards-path'];
					break;
					
				case 2:
					$path = Yii::getAlias('@frontend').'/web/'.Yii::$app->params['examples-path'];
					break;
					
				default:
					$path = Yii::getAlias('@frontend').'/web/'.Yii::$app->params['awards-path'];
					break;
			}
			
			if(file_exists($path.'/'.$media->filename))
				unlink($path.'/'.$media->filename);
		}
		
		if($model->price_list != '') {
			if(file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['pricelists-path'].'/'.$model->price_list))
				unlink(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['pricelists-path'].'/'.$model->price_list);
		}
		
		if($model->avatar != '') {
			if(file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['avatars-path'].'/'.$model->avatar))
				unlink(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['avatars-path'].'/'.$model->avatar);
		}
		
		if($model->license != '') {
			if(file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['licenses-path'].'/'.$model->license))
				unlink(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['licenses-path'].'/'.$model->license);
		}
		
		
		
        $model->delete();

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
        if (($model = SpecForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
