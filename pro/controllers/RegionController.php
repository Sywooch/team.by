<?php

namespace backend\controllers;

use Yii;
use common\models\Region;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * RegionController implements the CRUD actions for Region model.
 */
class RegionController extends Controller
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
     * Lists all Region models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Region::find()->where('id <> 1')->orderBy('lft, rgt'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Region model.
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
     * Creates a new Region model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Region();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {		
			$parent_category = Region::find()->where(['id' => $model->parent_id])->one();
			$model->appendTo($parent_category);
			
            return $this->redirect(['index']);
            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
				'categories' => $this->getCategoriesDropDownList(),
            ]);
        }
    }

    /**
     * Updates an existing Region model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$model->parent_id_old = $model->parent_id;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if($model->parent_id_old == $model->parent_id) {
				$model->save();
			}	else	{
				$parent_category = Region::find()->where(['id' => $model->parent_id])->one();
				$model->appendTo($parent_category);
			}
				
            return $this->redirect(['index']);
            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Region model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
    public function actionMoveup($id)
    {
		$model = $this->findModel($id);
		
		$model_prev = $model->prev()->one();
		
		if($model_prev != null)
			$model->insertBefore($model_prev);
		
		//echo'<pre>';print_r($model);echo'</pre>';//die;
		//echo'<pre>';var_dump($model_prev);echo'</pre>';die;
		
		return $this->redirect(['index']);		
    }

    public function actionMovedown($id)
    {
		$model = $this->findModel($id);
		
		$model_next = $model->next()->one();
		
		if($model_next != null)
			$model->insertAfter($model_next);
		
		//echo'<pre>';print_r($model);echo'</pre>';//die;
		//echo'<pre>';var_dump($model_prev);echo'</pre>';die;
		
		return $this->redirect(['index']);		
    }
	
    public function actionMakeroot()
    {
		$model = new Region(['name' => 'ROOT']);
		$model->makeRoot();		
		
		return $this->redirect(['index']);		
    }
	

    /**
     * Finds the Region model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Region the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Region::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
    //получает список категорий для выпадающего списка
	protected function getCategoriesDropDownList()
    {
		$categories = Region::find()->where('id <> 1')->orderBy('lft, rgt')->all();

		foreach($categories as $c){
			$separator = '';
			for ($x=0; $x++ < $c->depth;) $separator .= '-';
			$c->name = $separator.$c->name;
		}
		
		$categories = [1=>'Верхний уровень'] + ArrayHelper::map($categories, 'id', 'name');

		return $categories;
    }
	
}