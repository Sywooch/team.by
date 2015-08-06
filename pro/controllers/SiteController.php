<?php

namespace pro\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

use common\models\LoginForm;
use common\models\User;

use app\models\ContactForm;
//use app\models\ProfileAnketaForm;
//use app\models\ProfilePaymentTypeForm;

class SiteController extends Controller
{
    /*
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
	*/
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\E	rrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        /*
		if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
		
		$model = User::findOne(\Yii::$app->user->id);
		
		$ProfileAnketaForm = new ProfileAnketaForm();
		
		$ProfilePaymentTypeForm = ProfilePaymentTypeForm::findOne(\Yii::$app->user->id);

		//для коректной загрузки файлов аяксом
		//устанавливаем с какой моделью будем работать		
		Yii::$app->session->set('profile_model', 'ProfileAnketaForm');
		
		if ($ProfilePaymentTypeForm->load(Yii::$app->request->post())) {
			$ProfilePaymentTypeForm->save();
			//echo'<pre>';print_r($ProfilePaymentTypeForm);echo'</pre>';die;
			$this->redirect('/profile');
		}
		//echo'<pre>1212121';print_r($ProfilePaymentTypeForm);echo'</pre>';die;
		
		if ($ProfileAnketaForm->load(Yii::$app->request->post())) {
			if($ProfileAnketaForm->price_list != $model->price_list) {
				//удаляем старый прайс-лист
				if(file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['pricelists-path'].'/'.$model->price_list))
					unlink(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['pricelists-path'].'/'.$model->price_list);
				
				//перемещаем новый прайс-лист
				if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.$ProfileAnketaForm->price_list))
					rename(Yii::getAlias('@frontend').'/web/tmp/'.$ProfileAnketaForm->price_list, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['pricelists-path'].'/'.$ProfileAnketaForm->price_list);
			}
			
			if($ProfileAnketaForm->avatar != $model->avatar) {
				//удаляем старый аватар
				if(file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['avatars-path'].'/'.$model->avatar))
					unlink(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['avatars-path'].'/'.$model->avatar);
								
				//перемещаем фото аватара
				if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.$ProfileAnketaForm->avatar))
					rename(Yii::getAlias('@frontend').'/web/tmp/'.$ProfileAnketaForm->avatar, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['avatars-path'].'/'.$ProfileAnketaForm->avatar);
				
				if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$ProfileAnketaForm->avatar))
					rename(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$ProfileAnketaForm->avatar, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['avatars-path'].'/'.'thumb_'.$ProfileAnketaForm->avatar);
				
			}
			
			if($ProfileAnketaForm->license != $model->license) {
				//удаляем старую лицензию
				if(file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['licenses-path'].'/'.$model->license))
					unlink(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['licenses-path'].'/'.$model->license);
								
				//перемещаем лицензию
				if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.$ProfileAnketaForm->license))
					rename(Yii::getAlias('@frontend').'/web/tmp/'.$ProfileAnketaForm->license, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['licenses-path'].'/'.$ProfileAnketaForm->license);
				
				if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$ProfileAnketaForm->license))
					rename(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$ProfileAnketaForm->license, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['licenses-path'].'/'.'thumb_'.$ProfileAnketaForm->license);
				
			}
			
			$ProfileAnketaForm_attribs = $ProfileAnketaForm->toArray();
			$model_attr = $model->attributes;
			
			foreach($model_attr as $attr_key=>&$attr)	{
				if(isset($ProfileAnketaForm_attribs[$attr_key]))
					$model->$attr_key = $ProfileAnketaForm_attribs[$attr_key];
			}
			
			if($ProfileAnketaForm->passwordNew != '')
				$model->setPassword($ProfileAnketaForm->passwordNew);
			
			$model->user_status = 2; //после редактирования меняем статус на "Требует проверки".
			$model->save();
			
			$this->checkUslugi($model, $ProfileAnketaForm); //проверяем изменения в услугах
			
			$this->checkCategories($model, $ProfileAnketaForm); //проверяем изменения в категориях
			
			$this->checkAwards($model, $ProfileAnketaForm); //проверяем изменения в наградах дипломах
			
			$this->checkExamples($model, $ProfileAnketaForm); //проверяем изменения в примерах работ
			
			$this->redirect('/profile');
		}
		
		
		
		$ProfileAnketaForm->attributes = $model->toArray();
		
		foreach($model->userSpecials as $item)	{
			$ProfileAnketaForm->usluga[] = $item->category_id;
			$ProfileAnketaForm->price[$item->category_id] = $item->price;
		}
		
		$ProfileAnketaForm->awards = $model->media['awards'];
		$ProfileAnketaForm->examples = $model->media['examples'];
		
		$userCategories = $model->userCategories;
		
		//получаем родителя категорий, к которым относится пользователь
		$parents_cat = $userCategories[0]->category->parents(1)->one();
		$ProfileAnketaForm->category1 = $parents_cat->id;
		
		foreach($userCategories as $item)	{
			$ProfileAnketaForm->categories[] = $item->category_id;
		}
		
		$categories = Category::find()->where('id <> 1')->orderBy('lft, rgt')->all();
		
		$cats_l1 = [];
		$cats_l3 = [];

		foreach($categories as $c) {
			if($c->parent_id == 1)	{
				$cats_l1[] = [
					'id'=>$c->id,
					'name'=>$c->name,
					'alias'=>$c->alias,
					'path'=>$c->path,
					'children'=>[],
				];				
			}	elseif($c->depth > 2)	{
				$cats_l3[$c->parent_id][$c->id] = $c->name;
			}
		}		
		
		foreach($cats_l1 as &$c_l1) {
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
		
		$call_time = new \frontend\models\CallTimeForm();
		$call_time->call_from  = $model->call_time_from;
		$call_time->call_to = $model->call_time_to;
		
		$weekends_arr = [];
		foreach($model->userWeekend as $item) 
			$weekends_arr[] = Yii::$app->formatter->asDate(($item->weekend), 'php:d-m-yy');
		
		
		$weekends = new \frontend\models\SetWeekEndForm();
		$weekends->weekends = implode(';', $weekends_arr);
		
		//получаем поле для сортировки		
		$orderBy = Yii::$app->request->post('orderby', '');
		if($orderBy != '') {
			Yii::$app->response->cookies->add(new \yii\web\Cookie([
				'name' => 'orderlist-orderby',
				'value' => $orderBy,
			]));
			
			return $this->redirect(['/profile']);
		}	else	{
			$orderBy = Yii::$app->request->cookies->getValue('orderlist-orderby', 'created_at');
		}
		
		//$orderBy = 'id';
		
		//строим выпадающий блок для сортировки
		$ordering_arr = Yii::$app->params['orderlist-orderby'];
		$ordering_items = [];
		$current_ordering = ['name'=>'created_at', 'field'=>'дате добавления'];
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
		
		
		$ordersDataProvider = new ActiveDataProvider([
			'query' => \common\models\Order::find()
				->distinct(true)
				->joinWith(['client'])
				->where(['{{%order}}.user_id'=>$model->id])
				->orderBy('{{%order}}.'.$orderBy.' ASC'),
			
			'pagination' => [
				//'pageSize' => Yii::$app->params['catlist-per-page'],
				'pageSize' => 200,
				'pageSizeParam' => false,
			],
		]);
		
		$reviewsDataProvider = new ActiveDataProvider([
			'query' => \common\models\Review::find()
				->distinct(true)
				->joinWith(['client'])
				->joinWith(['reviewMedia'])
				->where(['{{%review}}.user_id'=>$model->id])
				->orderBy('{{%review}}.id DESC'),
			
			'pagination' => [
				//'pageSize' => Yii::$app->params['catlist-per-page'],
				'pageSize' => 200,
				'pageSizeParam' => false,
			],
		]);
		
		
		return $this->render('index', [
			'model' => $model,
			'ProfileAnketaForm' => $ProfileAnketaForm,
			'categories' => $cats_l1,
			'categories_l3' => $cats_l3,
			'call_time' => $call_time,
			'weekends' => $weekends,
			'ordersDataProvider' => $ordersDataProvider,
			'reviewsDataProvider' => $reviewsDataProvider,
			'ordering_items'=>$ordering_items,
			'current_ordering'=>$current_ordering,
			'ProfilePaymentTypeForm'=>$ProfilePaymentTypeForm,
			
		]);
		*/
		var_dump(\Yii::$app->user->id);
		return $this->render('index', []);
    }

    public function actionLogin()
    {
        /*
		if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
		*/
		
		//echo 'login';return;

        $model = new LoginForm();
		
		$request = Yii::$app->request;
		$modal = $request->get('modal');
		
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } elseif($modal == 1) {
            return $this->renderPartial('login-modal', [
                'model' => $model,
            ]);
			
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        var_dump(\Yii::$app->user->id);
		$model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
