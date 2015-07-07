<?php

namespace frontend\controllers;

use Yii;

use common\models\Category;
use common\models\User;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class CatalogController extends Controller
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

    public function actionIndex()
	{
		$categories = Category::find()->where('id <> 1')->orderBy('lft, rgt')->all();
		
		$cats_l1 = [];

		foreach($categories as $c){
			if($c->parent_id == 1)	$cats_l1[] = [
				'id'=>$c->id,
				'name'=>$c->name,
				'alias'=>$c->alias,
				'path'=>$c->path,
				'children'=>[],
			];
		}		
		
		foreach($cats_l1 as &$c_l1){
			foreach($categories as $c){
				if($c->parent_id == $c_l1['id']) {
					$c_l1['children'][] = [
						'id'=>$c->id,
						'name'=>$c->name,
						'alias'=>$c->alias,
						'path'=>$c->path,
					];
				}
			}
		}
		//echo'<pre>';print_r($cats_l1);echo'</pre>';
		
		return $this->render('index', [
			'categories' => $cats_l1,
		]);
		
	}
	
    public function actionCategory($category)
    {
         //echo'<pre>';print_r($category);echo'</pre>';
		// Ищем категорию по переданному пути
        $category = Category::find()
			->where(['path' => $category])
			->one();			

        if ($category === null)
            throw new CHttpException(404, 'Not found');
		
		//получаем всех родителей данной категории для хлебной крошки
		$parents = $category->parents()->all();
		
		$DataProvider = new ActiveDataProvider([
			'query' => User::find()
			->join('INNER JOIN', '{{%user_categories}} AS uc', 'uc.user_id = {{%user}}.id')
				->where(['uc.category_id'=>$category->id])
				->orderBy('{{%user}}.id ASC'),
			
			'pagination' => [
				'pageSize' => 5,
				'pageSizeParam' => false,
			],
		]);		
		//echo'<pre>';print_r($DataProvider->models);echo'</pre>';
 		/*
        $criteria = new CDbCriteria();
        $criteria->addInCondition('t.category_id', array_merge(array($category->id), $category->getChildsArray()));
 
        $dataProvider = new CActiveDataProvider(ShopProduct::model()->cache(3600), array(
            'criteria'=>$criteria,
            'pagination'=> array(
                'pageSize'=>self::PRODUCTS_PER_PAGE,
                'pageVar'=>'page',
            )
        ));
 
        $this->render('category', array(
            'dataProvider'=>$dataProvider,
            'category'=>$category,
        ));
		*/
		return $this->render('category', [
			'category'=>$category,
			'parents'=>$parents,
			'dataProvider'=>$DataProvider,
		]);
    }    
 
    public function actionShow($category, $id)
    {
        echo'<pre>';print_r($category);echo'</pre>';
        echo'<pre>';print_r($id);echo'</pre>';
		
		//$model = $this->loadModel($id)
 
       // $this->render('show', array('model'=>$model));
        return $this->render('show', []);

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
}
