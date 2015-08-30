<?php

namespace backend\controllers;

use Yii;
use common\models\Client;
use backend\models\ClientSearch;

use common\helpers\DCsvHelper;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\InvalidRouteException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends Controller
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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
	

    /**
     * Lists all Client models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->chekUserAdminOrManager();
		
        $searchModel = new ClientSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
        return $this->render('index', [
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Client model.
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
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->chekUserAdminOrManager();
		
		$model = new Client();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Client model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->chekUserAdminOrManager();
		
		$model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Client model.
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

    public function actionExportCsv()
    {
        $this->chekUserAdminOrManager();
		
		//$this->findModel($id)->delete();
		
        return $this->render('export-csv');
    }

    public function actionExportGo()
    {
        $this->chekUserAdminOrManager();
		
		//$this->findModel($id)->delete();
		$csv = new DCsvHelper();
		
		$client = Client::find()
			->orderBy('fio')
			->all();
		
		echo Yii::getAlias('@frontend') . Yii::$app->params['export-client-path'];
        
		$filename = Yii::$app->basePath . '/web/' . Yii::$app->params['export-path']."/client-export.csv";
		
        $data = [];
        $head = ["id","fio","phone","email","info","created_at","black_list"];
        $data[] = $head;
        
        foreach($client as $item){
            $row = array();
            $row[] = $item->id;
            //$row[] = ($item->fio); 
            $row[] = mb_convert_encoding($item->fio, 'Windows-1251', 'UTF-8');
            $row[] = $item->phone;
            $row[] = $item->email;
			$row[] = mb_convert_encoding($item->info, 'Windows-1251', 'UTF-8');
            $row[] = Yii::$app->formatter->asDate($item->created_at, 'php:d-m-yy');
			$row[] = $item->black_list;
            $data[] = $row; 
        }
		
        
        //$csv = new csv();
        $csv->write($filename, $data);
		
		$file_link = Html::a('Скачать файл', '@web/' . Yii::$app->params['export-path']."/client-export.csv");
		
		Yii::$app->session->setFlash('success', 'Создание файла завершено. '.$file_link);
		
        return $this->render('export-csv-complete');
    }

    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne($id)) !== null) {
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
