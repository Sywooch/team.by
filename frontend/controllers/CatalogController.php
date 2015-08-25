<?php

namespace frontend\controllers;

use Yii;

use common\models\Category;
use common\models\User;
use common\models\Review;
use common\models\Region;
use common\models\UserRegion;

use frontend\models\UserSearch;



use yii\data\ActiveDataProvider;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;

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
		$categories = Category::find()->where('id <> 1 AND depth < 3')->orderBy('lft, rgt')->all();
		
		\common\helpers\DCategoryHelper::prepareMainCategoriesForView($categories);

		return $this->render('index', [
			'categories' => $categories,
		]);
		
	}
	
    public function actionCategory($category)
    {
		//получаем из куки ИД региона
		$region_id = \Yii::$app->getRequest()->getCookies()->getValue('region', 1);
		
		//получаем поле для сортировки
		/*
		$orderBy = Yii::$app->request->post('orderby', '');
		if($orderBy != '') {
			Yii::$app->response->cookies->add(new \yii\web\Cookie([
				'name' => 'catlist-orderby',
				'value' => $orderBy,
			]));
			
			//return $this->redirect(['category', 'category'=>$category]);
		}	else	{
			$orderBy = Yii::$app->request->cookies->getValue('catlist-orderby', 'fio');
		}
		*/
		//строим выпадающий блок для сортировки
		$ordering_arr = Yii::$app->params['catlist-orderby'];
		$ordering_items = [];
		foreach($ordering_arr as $k=>$i) {
			if($k == $orderBy)	{
				$current_ordering = ['name'=>$i, 'field'=>$k];
			}	else	{
				$ordering_items[] = [
					'label'=>$i,
					'url' => '#',
					'linkOptions' => ['data-sort' => $k],
				];
			}
		}
		
         //echo'<pre>';print_r($category);echo'</pre>';
		// Ищем категорию по переданному пути
        $category = Category::find()
			->where(['path' => $category])
			->one();			

        if ($category === null)
            throw new NotFoundHttpException('Категория не найдена');
		
		//получаем всех родителей данной категории для хлебной крошки
		$parents = $category->parents()->all();
		
		//получаем потомков категории
		$children = $category->children()->all();
		//echo'<pre>';print_r($category->depth);echo'</pre>'; //die;
		if(count($children)) {
			switch($category->depth) {
				case 1:
					$table = 'user_categories';
					break;
				case 2:
					$table = 'user_specials';
					break;
			}
			
			\common\helpers\DCategoryHelper::prepareCatalogCategories($children, $table);
		}
		
		//получаем массив ИД категорий для поиска аккаунтов в них
		$cat_ids = [$category->id];
		foreach($children as $k=>$c)	{
			if($category->depth > 1) {
				$cat_ids[] = $c->id;
			}	else	{
				if($c->depth < 3)	{				
					$cat_ids[] = $c->id;
				}	else	{
					//на 3-м уровне у нас идут виды работ. Их нужно исключить
					unset($children[$k]);
				}
			}
			
		}
		
		$query = $this->prepareQuery();
		if($category->depth > 2) {
			$query->joinWith(['userSpecials'])
				->where(['{{%user_specials}}.category_id'=>$cat_ids]);
		} else {
			$query->where(['{{%user_categories}}.category_id'=>$cat_ids]);
		}
		
		$query->andWhere(['<>', 'black_list', 1])
			->andWhere(['=', 'is_active', 1])
			->andWhere(['user_status'=> User::getActiveUserStatuses()])
			//->orderBy('{{%user}}.'.$orderBy.' ASC');
			->orderBy('{{%user}}.total_rating DESC');
		
		//если указан какой-то регион - то фильтруем по нему и его потомкам
		if($region_id != 1) {
			$region = Region::findOne($region_id);
			$region_children = $region->children()->all();
			$region_ids = [$region_id => $region_id] + ArrayHelper::map($region_children, 'id', 'id');
			
			//$user_regions = UserRegion::find()->where(['region_id'=>$region_ids])->all();
			//echo'<pre>';print_r($user_regions);echo'</pre>';
			
			$query->joinWith(['userRegions'])
				->andWhere(['{{%user_region}}.region_id' => $region_ids]);
		}	else	{
			
		}
		
		
		$DataProvider = new ActiveDataProvider([
			'query' => $query,
			
			'pagination' => [
				'pageSize' => Yii::$app->params['catlist-per-page'],
				//'pageSize' => 2,
				'pageSizeParam' => false,
			],
		]);
				
		$categories_history = Yii::$app->session->get('categories_history', []);
		//echo'<pre>';print_r($categories_history);echo'</pre>';
		foreach($DataProvider->models as $model)	{
			$categories_history[$model->id] = $category->id;
		}
		
		Yii::$app->session->set('categories_history', $categories_history);

		return $this->render('category', [
			'category'=>$category,
			'parents'=>$parents,
			'children'=>$children,
			'dataProvider'=>$DataProvider,
			'current_ordering'=>$current_ordering,
			'ordering_items'=>$ordering_items,
			'specials'=>$this->getSpecials(),
		]);
    }    
 
    public function actionBlackList()
    {
		//получаем поле для сортировки
		/*
		$orderBy = Yii::$app->request->post('orderby', '');
		if($orderBy != '') {
			Yii::$app->response->cookies->add(new \yii\web\Cookie([
				'name' => 'catlist-orderby',
				'value' => $orderBy,
			]));
		}	else	{
			$orderBy = Yii::$app->request->cookies->getValue('catlist-orderby', 'fio');
		}
		*/
		//строим выпадающий блок для сортировки
		$ordering_arr = Yii::$app->params['catlist-orderby'];
		$ordering_items = [];
		foreach($ordering_arr as $k=>$i) {
			if($k == $orderBy)	{
				$current_ordering = ['name'=>$i, 'field'=>$k];
			}	else	{
				$ordering_items[] = [
					'label'=>$i,
					'url' => '#',
					'linkOptions' => ['data-sort' => $k],
				];
			}
				
		}
		$query = $this->prepareQuery();
		$query->where(['black_list'=>1])
			//->orderBy('{{%user}}.'.$orderBy.' ASC');
			->orderBy('{{%user}}.total_rating DESC');
		/*
		$query = User::find()
			->distinct(true)
			->joinWith(['reviews'])
			->joinWith(['userMedia'])
			->where(['black_list'=>1])
			//->orderBy('{{%user}}.'.$orderBy.' ASC');
			->orderBy('{{%user}}.total_rating DESC');
		*/
		
		$DataProvider = new ActiveDataProvider([
			'query' => $query,
			
			'pagination' => [
				'pageSize' => Yii::$app->params['catlist-per-page'],
				//'pageSize' => 1,
				'pageSizeParam' => false,
			],
		]);
				
		return $this->render('black-list', [
			'dataProvider'=>$DataProvider,
			'current_ordering'=>$current_ordering,
			'ordering_items'=>$ordering_items,
			'specials'=>$this->getSpecials(),
		]);
    }    
 
    public function actionShow($category, $id)
    {
        $categories_history = Yii::$app->session->get('categories_history', []);
		
		$model = User::findOne($id);		
		if ($model === null) throw new CHttpException(404, 'Аккаунт с данным ID отсутствует в базе');		
		
		//echo'<pre>';print_r($categories_history);echo'</pre>'; die;
		//echo'<pre>';print_r($model->userCategories[0]);echo'</pre>'; die;
		
		if(count($categories_history) && isset($categories_history[$id]))	{
			$category = Category::find()
				->where(['id' => $categories_history[$id]])
				->one();

			if($category === null) throw new NotFoundHttpException('Ошибка категории');
		}	else	{
			$category = Category::find()
				->where(['id' => $model->userCategories[0]->category_id])
				->one();

			if($category === null) throw new NotFoundHttpException('Ошибка категории');
		}
		
		//получаем всех родителей данной категории для хлебной крошки
		$parents = $category->parents()->all();
		
		//получаем потомков категории
		$children = $category->children()->all();
		
		//получаем массив ИД категорий для поиска аккаунтов в них
		$cat_ids = [$category->id];
		foreach($children as $k=>$c)	{
			if($c->depth < 3)	{				
				$cat_ids[] = $c->id;
			}	else	{
				//на 3-м уровне у нас идут виды работ. Их нужно исключить
				unset($children[$k]);
			}
		}
		
		$relatedDataProvider = new ActiveDataProvider([
			'query' => User::find()
				->distinct(true)
				->joinWith(['userCategories'])
				->joinWith(['userSpecials'])
				->where(['{{%user_categories}}.category_id'=>$cat_ids])
				->andWhere(['=', 'is_active', 1])
				->andWhere(['user_status'=> User::getActiveUserStatuses()])
				->andWhere(['<>', '{{%user}}.id', $id])
				->orderBy('RAND()'),
			
			'pagination' => [
				'pageSize' => 5,
				'pageSizeParam' => false,
			],
		]);		
		
		$reviews_count = Review::find()
			->where(['user_id'=>$model->id])
			->count();
		
		$reviews_list = Review::find()
			->where(['user_id'=>$model->id])
			->andWhere(['status'=>1])
			->joinWith(['client'])
			->limit(3)
			->orderBy('id DESC')
			->all();
		
		//$model = $this->loadModel($id)
		
		//echo'<pre>';print_r($this->getSpecials());echo'</pre>'; die;
 
        return $this->render('show', [
			'model'=>$model,
			'category'=>$category,
			'parents'=>$parents,
			'children'=>$children,
			'relatedDataProvider'=>$relatedDataProvider,
			'specials'=>$this->getSpecials(),
			'reviews_list'=>$reviews_list,
			'reviews_count'=>$reviews_count,
		]);

    }
	
    public function actionSearch()
    {
		$search = Yii::$app->request->get('profi_search', '');
		$region_id = Yii::$app->request->get('region_id', 1);
		$modal = Yii::$app->request->get('modal', 0);
		
		if($search != '') {
			
			
			
			
			//получаем поле для сортировки
			/*
			$orderBy = Yii::$app->request->post('orderby', '');
			if($orderBy != '') {
				Yii::$app->response->cookies->add(new \yii\web\Cookie([
					'name' => 'catlist-orderby',
					'value' => $orderBy,
				]));
			}	else	{
				$orderBy = Yii::$app->request->cookies->getValue('catlist-orderby', 'rating_total');
			}
			*/
			if($modal == 0) {
				$UserSearch = new UserSearch();

				$user_ids = $UserSearch->searchUsers($search, $region_id);

				//строим выпадающий блок для сортировки
				$ordering_arr = Yii::$app->params['catlist-orderby'];
				$ordering_items = [];
				foreach($ordering_arr as $k=>$i) {
					if($k == $orderBy)	{
						$current_ordering = ['name'=>$i, 'field'=>$k];
					}	else	{
						$ordering_items[] = [
							'label'=>$i,
							'url' => '#',
							'linkOptions' => ['data-sort' => $k],
						];
					}

				}

				$query = $this->prepareQuery();
				$query->where(['{{%user}}.id'=>$user_ids])
					//->orderBy('{{%user}}.'.$orderBy.' ASC');
					->orderBy('{{%user}}.total_rating DESC');
				/*
				$query = User::find()
					->distinct(true)
					->joinWith(['reviews'])
					->joinWith(['userMedia'])
					->where(['{{%user}}.id'=>$user_ids])
					//->andWhere('black_list <> 1')
					//->andWhere('user_status IN (2,10)')
					//->orderBy('{{%user}}.'.$orderBy.' ASC');
					->orderBy('{{%user}}.total_rating DESC');
				*/
				$DataProvider = new ActiveDataProvider([
					'query' => $query,
					'pagination' => [
						'pageSize' => Yii::$app->params['catlist-per-page'],
						'pageSizeParam' => false,
					],
				]);
				
				$query = Category::find()
					->where(['like', 'name', $search])
					->andWhere(['>', 'id', 1])
					//->andWhere(['<', 'depth', 3])
					->orderBy('lft, rgt');
				
				//echo'<pre>';print_r($query);echo'</pre>';

				$catDataProvider = new ActiveDataProvider([
					'query' => $query,
					'pagination' => false,
				]);
				
				//echo'<pre>';print_r($catDataProvider->models);echo'</pre>';
				
				
				return $this->render('search', [
					'dataProvider'=>$DataProvider,
					'catdataProvider'=>$catDataProvider,
					'current_ordering'=>$current_ordering,
					'ordering_items'=>$ordering_items,
					'specials'=>$this->getSpecials(),
				]);
				
			}	else	{
				$user_ids = [0];
				$query = User::find()
					->distinct(true)
					->where(['{{%user}}.id'=>$user_ids])
					//->orderBy('{{%user}}.'.$orderBy.' ASC');
					->orderBy('{{%user}}.total_rating DESC');

				$DataProvider = new ActiveDataProvider([
					'query' => $query,
					'pagination' => false,
				]);
				
				
				$query = Category::find()
					->where(['like', 'name', $search])
					->andWhere(['>', 'id', 1])
					//->andWhere(['<', 'depth', 3])
					->orderBy('lft, rgt');
				
				//echo'<pre>';print_r($query);echo'</pre>';

				$catDataProvider = new ActiveDataProvider([
					'query' => $query,
					'pagination' => false,
				]);
								
				return $this->renderPartial('search-modal', [
					'dataProvider'=>$DataProvider, 
					'catdataProvider'=>$catDataProvider
				]);
			}
			
		}	else	{
			if($modal == 0) {
				return $this->render('search-no-qry');
			}	else	{
				return $this->render('search-modal-no-qry');
			}
			
		}
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
	
	public function getSpecials()
	{
		$specials = Category::find()->where('depth > 2')->orderBy('lft, rgt')->all();
		$specials = ArrayHelper::map($specials, 'id', 'name');
		return $specials;
	}
	
	public function prepareQuery()
	{
		$query = User::find()
			->distinct(true)
			->joinWith(['userCategories'])
			->joinWith(['reviews'])
			->joinWith(['userMedia'])
			->joinWith(['userRegionsList']);
		
		return $query;
	}
	
	/*
	public function getNonEmptyCategories(&$children, $table)
	{
		$command = \Yii::$app->db->createCommand('SELECT `category_id`, count(`user_id`) AS count FROM {{%'.$table.'}} AS uc INNER JOIN {{%user}} AS u ON u.id = uc.user_id WHERE u.is_active = 1 AND u.`user_status` IN('.implode(',', \common\models\User::getActiveUserStatuses()).') GROUP BY `category_id`');
		$with_specs = $command->queryAll();				

		$children_n = [];
		foreach($children as $child) {
			foreach($with_specs as $row) {
				if($row['category_id'] == $child->id) {
					$children_n[] = $child;
				}
			}
		}
		$children = $children_n;
	}
	*/
}
