<?php

namespace backend\controllers;

use Yii;

//use backend\models\User;
use common\models\User;
use backend\models\UserSearch;

use backend\models\SpecForm;

use frontend\models\DocumentsForm1;
use frontend\models\DocumentsForm2;
use frontend\models\DocumentsForm3;

use app\models\ChangePasswordForm;

use common\helpers\DCsvHelper;

use yii\data\ActiveDataProvider;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

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
		$this->chekUserAdminOrManager();
		
        $searchModel = new UserSearch();
		$dataProvider = $searchModel->searchSpecs(Yii::$app->request->queryParams);
		
        return $this->render('index', [
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
		
    }
	
    public function actionDeleted()
    {
		$this->chekUserAdminOrManager();
		
        $searchModel = new UserSearch();
		$dataProvider = $searchModel->searchSpecsDeleted(Yii::$app->request->queryParams);
		
        return $this->render('index-deleted', [
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
        $this->chekUserAdminOrManager();
		
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
					//$document_form = 'DocumentsForm1';
					$document_form = new DocumentsForm1();

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
					//$document_form = 'DocumentsForm2';
					$document_form = new DocumentsForm2();

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


					//$tmpl = 'documents-2';
					break;
				case 3:
					//$document_form = 'DocumentsForm3';

					$document_form = new DocumentsForm3();
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

					//$tmpl = 'documents-3';
					break;
			}
			
			$userCategories = $model->userCategories;
			//echo'<pre>';print_r($userCategories);echo'</pre>';die;

			//получаем родителя категорий, к которым относится пользователь
			if(isset($userCategories[0])) {
				$parents_cat = $userCategories[0]->category->parents(1)->one();
				$model->categoryUser = $parents_cat->id;				
			}	else	{
				$model->categoryUser = 0;
			}
			
			//echo'<pre>';print_r($model->categoryUser);echo'</pre>';//die;
			
			
			
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
        $this->chekUserAdminOrManager();
		
		$model = $this->findModel($id);
		
		$model->user_status = 3;
		$model->save();
		/*
		
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
		*/
        return $this->redirect(['index']);
    }
	
    //полное удаление аккаунта из базы
	public function actionDeleteTotal($id)
    {
        $this->chekUserAdminOrManager();
		
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
        $this->chekUserAdminOrManager();
		
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

    public function actionDelFile($id)
    {
        $this->chekUserAdminOrManager();
		
		$model = $this->findModel($id);
		$task = Yii::$app->request->get('task', '');
		$file = Yii::$app->request->get('file', '');
		if($file == '' || $task == '') return $this->redirect(['index']);
		
		$fileToDelete = '';
		$fileToDeleteTmb = '';
		
		switch($task) {
			case 'youtube':
				$model->youtube = '';
				$model->save();
				break;
			case 'avatar':
				$fileToDelete = Yii::getAlias('@frontend').'/web/'.Yii::$app->params['avatars-path'].'/'.$model->avatar;
				$fileToDeleteTmb = Yii::getAlias('@frontend').'/web/'.Yii::$app->params['avatars-path'].'/thumb_'.$model->avatar;
				$model->avatar = '';
				$model->save();
				break;
			case 'awards':
				$fileToDelete = Yii::getAlias('@frontend').'/web/'.Yii::$app->params['awards-path'].'/'.$file;
				
				foreach($model->userMedia as $media)
					if($media->filename == $file)
						$media->delete();
					
				break;
			case 'examples':
				$fileToDelete = Yii::getAlias('@frontend').'/web/'.Yii::$app->params['examples-path'].'/'.$file;
				
				foreach($model->userMedia as $media)
					if($media->filename == $file)
						$media->delete();

				break;
		}
		
		if($fileToDelete != '' && file_exists($fileToDelete))
			unlink($fileToDelete);
		   
		if($fileToDeleteTmb != '' && file_exists($fileToDeleteTmb))
			unlink($fileToDeleteTmb);
		   
		 Yii::$app->session->setFlash('success', 'Файл успешно удален.'); 
		
		return $this->redirect(['update', 'id'=>$id]);		
    }
	
    public function actionExportCsv()
    {
        $this->chekUserAdminOrManager();
		
        return $this->render('export-csv');
    }

    public function actionExportGo()
    {
        $this->chekUserAdminOrManager();
		
		$csv = new DCsvHelper();
		
		$spec = User::find()
			->where(['group_id'=>2])
			->andWhere(['>', 'id', 0])
			->orderBy('fio')
			->all();
		
		echo Yii::getAlias('@frontend') . Yii::$app->params['export-client-path'];
        
		$filename = Yii::$app->basePath . '/web/' . Yii::$app->params['export-path']."/spec-export.csv";
		
        $data = [];
        $head = [
			"id",
			"fio",
			"phone",
			"email",
			"created_at",
			"about",
			"education",
			"experience",
			"price_list",
			"specialization",
			"total_rating",
			"black_list",
			"youtube",
			"comment",
		];
        $data[] = $head;
		
        foreach($spec as $item){
            $row = array();
            $row[] = $item->id;
            //$row[] = ($item->fio); 
            $row[] = mb_convert_encoding($item->fio, 'Windows-1251', 'UTF-8');
            $row[] = $item->phone;
            $row[] = $item->email;
			$row[] = Yii::$app->formatter->asDate($item->created_at, 'php:d-m-yy');
			$row[] = mb_convert_encoding($item->about, 'Windows-1251', 'UTF-8');
			$row[] = mb_convert_encoding($item->education, 'Windows-1251', 'UTF-8');
			$row[] = mb_convert_encoding($item->experience, 'Windows-1251', 'UTF-8');
			$row[] = mb_convert_encoding($item->price_list, 'Windows-1251', 'UTF-8');
			$row[] = mb_convert_encoding($item->specialization, 'Windows-1251', 'UTF-8');
			$row[] = mb_convert_encoding($item->total_rating, 'Windows-1251', 'UTF-8');
			$row[] = mb_convert_encoding($item->black_list, 'Windows-1251', 'UTF-8');
			$row[] = mb_convert_encoding($item->youtube, 'Windows-1251', 'UTF-8');
			$row[] = mb_convert_encoding($item->comment, 'Windows-1251', 'UTF-8');
            
            $data[] = $row; 
        }
		
        
        //$csv = new csv();
        $csv->write($filename, $data);
		
		$file_link = Html::a('Скачать файл', '@web/' . Yii::$app->params['export-path']."/spec-export.csv");
		
		Yii::$app->session->setFlash('success', 'Создание файла завершено. '.$file_link);
		
        return $this->render('export-csv-complete');
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
