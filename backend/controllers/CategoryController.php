<?php

namespace backend\controllers;

use Yii;
use app\models\Category;
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
            'query' => Category::find()->orderBy('lft, rgt'),
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
			//echo'<pre>';print_r($model->attributes);echo'<pre>';die;
			//$model->save();
			
			if($model->parent_id == 0) {
				$model->makeRoot();
			}	else	{
				$parent_category = Category::find()->where(['id' => $model->parent_id])->one();
				$model->appendTo($parent_category);
			}			
            return $this->redirect(['index']);
        } else {
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
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

        return $this->redirect(['index']);
    }

    public function actionMakeroot()
    {
		$countries = new Category(['name' => 'Countries']);
		$countries->makeRoot();		
		return $this->redirect(['index']);
    }

    public function actionPrependto()
    {
		//$countries = Category(['name' => 'Countries']);
		
		$countries = Category::find()
			->where(['id' => 1])
			->one();
		$russia = new Category(['name' => 'Russia']);
		$russia->appendTo($countries);		
		return $this->redirect(['index']);
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
		$categories = Category::find()->orderBy('lft, rgt')->all();

		foreach($categories as $c){
			$separator = '';
			for ($x=0; $x++ < $c->depth;) $separator .= '-';
			$c->name = $separator.$c->name;
		}
		
		$categories = [0=>'Верхний уровень'] + ArrayHelper::map($categories, 'id', 'name');

		return $categories;
    }
}
