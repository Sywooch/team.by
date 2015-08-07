<?php

namespace backend\controllers;

use Yii;
use common\models\Category;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find()
				->where(['<>', 'id', 1])
				->orderBy('lft, rgt'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$this->checkAlias($model);
			//echo'<pre>';print_r($model->attributes);echo'<pre>';die;
			//$model->save();
			
			$parent_category = Category::find()->where(['id' => $model->parent_id])->one();
			$model->appendTo($parent_category);
				
			$session = Yii::$app->session;
			$returnUrl = $session->get('category-return-url', null);
			if($returnUrl != null) return $this->redirect($returnUrl);
				else return $this->redirect(['index']);
            //return $this->redirect(['index']);
			
        } else {
			if(count($model->errors) == 0) {
				$returnUrl = Yii::$app->request->referrer;
				$session = Yii::$app->session;
				$session->set('category-return-url', $returnUrl);
			}
			
            return $this->render('create', [
                'model' => $model,
                'categories' => $this->getCategoriesDropDownList(),
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$model->parent_id_old = $model->parent_id;
		$model->path = '';
		
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {			
			$this->checkAlias($model);

			if($model->parent_id_old == $model->parent_id) {
				$model->save();
			}	else	{
				$parent_category = Category::find()->where(['id' => $model->parent_id])->one();
				$model->appendTo($parent_category);
			}
			
			$session = Yii::$app->session;
			$returnUrl = $session->get('category-return-url', null);
			if($returnUrl != null) return $this->redirect($returnUrl);
				else return $this->redirect(['index']);
            //return $this->redirect(['index']);
			
        } else {
			
			if(count($model->errors) == 0) {
				$returnUrl = Yii::$app->request->referrer;
				$session = Yii::$app->session;
				$session->set('category-return-url', $returnUrl);
			}
			
            return $this->render('update', [
                'model' => $model,
				'categories' => $this->getCategoriesDropDownList(),
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		
		$returnUrl = Yii::$app->request->referrer;		
		if($returnUrl != null) return $this->redirect($returnUrl);
			else return $this->redirect(['index']);

        //return $this->redirect(['index']);
    }

    public function actionMoveup($id)
    {
		$model = $this->findModel($id);
		
		$model_prev = $model->prev()->one();
		
		if($model_prev != null)
			$model->insertBefore($model_prev);
		
		//echo'<pre>';print_r($model);echo'</pre>';//die;
		//echo'<pre>';var_dump($model_prev);echo'</pre>';die;
		$returnUrl = Yii::$app->request->referrer;		
		if($returnUrl != null) return $this->redirect($returnUrl);
			else return $this->redirect(['index']);
		
		
		//return $this->redirect(['index']);		
    }

    public function actionMovedown($id)
    {
		$model = $this->findModel($id);
		
		//echo'<pre>';print_r($model->attributes);echo'</pre>';//die;
		
		$model_next = $model->next()->one();
		
		if($model_next != null)
			$model->insertAfter($model_next);
		
		//echo'<pre>';print_r($model->attributes);echo'</pre>';//die;
		//echo'<pre>';print_r($model_next->attributes);echo'</pre>';die;
		//echo'<pre>';var_dump($model_prev);echo'</pre>';die;
		$returnUrl = Yii::$app->request->referrer;		
		if($returnUrl != null) return $this->redirect($returnUrl);
			else return $this->redirect(['index']);
		
		//return $this->redirect(['index']);		
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
    //получает список категорий для выпадающего списка
	protected function getCategoriesDropDownList()
    {
		$categories = Category::find()->where('id <> 1')->orderBy('lft, rgt')->all();

		foreach($categories as $c){
			$separator = '';
			for ($x=0; $x++ < $c->depth;) $separator .= '-';
			$c->name = $separator.$c->name;
		}
		
		$categories = [1=>'Верхний уровень'] + ArrayHelper::map($categories, 'id', 'name');

		return $categories;
    }
	
	protected function checkAlias(&$model)
    {
		$search = [' ', '(', ')', '/', '*'];
		$replace = ['-', '', '', '-', ''];
		if($model->alias == '') $model->alias = str_replace($search, $replace, (strtolower($model->ToTranslit($model->name)))) ;
	}
	
	
}
