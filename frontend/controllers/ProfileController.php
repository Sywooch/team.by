<?php

namespace frontend\controllers;

use Yii;

use common\models\Category;
use common\models\User;
use common\models\UserCategories;
use common\models\UserSpecials;
use common\models\UserMedia;


use frontend\models\ProfileAnketaForm;


use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ProfileController extends Controller
{

    public function actionIndex()
	{
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
		
		$model = User::findOne(\Yii::$app->user->id);
		
		$ProfileAnketaForm = new ProfileAnketaForm();

		//для коректной загрузки файлов аяксом
		//устанавливаем с какой моделью будем работать		
		Yii::$app->session->set('profile_model', 'ProfileAnketaForm');
		
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
			
			$model->user_status = 2; //после редактирования меняем статус.
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
			
		]);
		
	}
	
    public function actionDelete()
	{
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
		
		return $this->render('profile-delete');
	}
	
    public function actionSetActivity()
	{
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
		
		$activity = (int) Yii::$app->request->post('activity', 1);
		$return_url = (string) Yii::$app->request->post('return_url', '');
		
		if($activity == 1 || $activity == 0) {
			$model = User::findOne(\Yii::$app->user->id);
			$model->is_active = $activity;
			$model->save(false);
			return $this->redirect($return_url);
		}	else	{
			return $this->goHome();
		}
	}
	
    public function actionSetCalltime()
	{
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
		
		$model = new \frontend\models\CallTimeForm();

		if ($model->load(Yii::$app->request->post())) {
			if ($model->validate()) {
				$user = User::findOne(\Yii::$app->user->id);
				$user->call_time_from = $model->call_from;
				$user->call_time_to = $model->call_to;
				$user->save(false);
			}
		}
		return $this->redirect('/profile');
	}
	
    //установить выходные
	public function actionSetWeekend()
	{
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
		
		$model = new \frontend\models\SetWeekEndForm();
		//echo'<pre>';print_r(Yii::$app->request->post());echo'</pre>';die;
		if ($model->load(Yii::$app->request->post())) {
			if ($model->validate()) {
				
				//получаем ранее сохраненные выходные
				$weekends_prev = [];
				$user = User::findOne(\Yii::$app->user->id);
				foreach($user->userWeekend as $item) $weekends_prev[] = $item->weekend;
				$weekends_prev_str = implode(';', $weekends_prev);
				
				//если не совпадают с текущими то обновляем
				if($weekends_prev != $model->weekends) {
					foreach($user->userWeekend as $item) $item->delete();
					
					$weekedns_arr = explode(';', $model->weekends);				
					foreach($weekedns_arr as $item) {
						if($item != '') {
							$item_arr = explode('-', $item);
							//echo'<pre>';print_r($item_arr);echo'</pre>';die;
							$userWeekEnd = new \common\models\UserWeekend();
							$userWeekEnd->user_id = \Yii::$app->user->id;
							$userWeekEnd->weekend = mktime(00, 00, 00, $item_arr[1], $item_arr[2], $item_arr[0]);
							$userWeekEnd->save();
							//echo'<pre>';print_r($userWeekEnd);echo'</pre>';die;
						}
					}
					Yii::$app->session->setFlash('success', 'Выходные успешно обновлены.');
				}
			}	else	{
				Yii::$app->session->setFlash('error', 'При сохранении возникла ошибка');
			}
		}
		return $this->redirect('/profile');
	}
	

	public function actionToAdministration()
	{
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
		$model = new \frontend\models\ToAdministrationForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$user = User::findOne(\Yii::$app->user->id);
			$model->fio = $user->fio;
			
			$UserToAdministration = new \common\models\UserToAdministration();
			$UserToAdministration->user_id = \Yii::$app->user->id;
			$UserToAdministration->subject = $model->subject;
			$UserToAdministration->comment = $model->body;
			if($UserToAdministration->validate()) {
				$UserToAdministration->save();
				Yii::$app->session->setFlash('success', 'Ваше сообщение успешно отправлено');
			}	else	{
				Yii::$app->session->setFlash('error', 'При отправке сообщения возникла ошибка');
			}
			
			
			/*
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Ваше сообщение успешно отправлено');
            } else {
                Yii::$app->session->setFlash('error', 'При отправке сообщения возникла ошибка');
            }
			*/

            return $this->refresh();
        } else {
            return $this->render('to-administration', [
                'model' => $model,
            ]);
        }
		
	}

	public function actionAddAnswer($id)
	{
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
		
		//$review = \common\models\Review::findOne($id);
		
		$model = \frontend\models\AddAnswerReviewForm::findOne($id);
		
		if($model === null) {
			Yii::$app->session->setFlash('error', 'Запрашиваемый отзыв отсутствует');
			return $this->renderPartial('add-answer-modal-err', []);
		}	elseif($model->answer_text != '')	{
			Yii::$app->session->setFlash('error', 'Ответ уже добавлен');
			return $this->renderPartial('add-answer-modal-err', []);
		}
		
		

		if ($model->load(Yii::$app->request->post())) {
			if ($model->validate()) {
				$model->save();
				
				Yii::$app->session->setFlash('success', 'Ответ успешно размещен. После проверки от будет опубликован');
				return $this->renderPartial('add-answer-modal-err', []);
			}
		}

		return $this->renderPartial('add-answer-modal', [
			'model' => $model,
		]);
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
	
	//проверяем изменения в услугах
	public function checkUslugi($model, $ProfileAnketaForm)
	{
		$array_identical = false;
		if(count($model->userSpecials) != count($ProfileAnketaForm->usluga)) {
			$array_identical = false;
		}	else	{
			foreach($model->userSpecials as $model_spec)	{
				$array_identical = false;
				foreach($ProfileAnketaForm->usluga as $usluga)	{
					if($model_spec->category_id == $usluga)
						$array_identical = true;
				}
			}
		}

		if($array_identical == false) {
			foreach($model->userSpecials as $model_spec)	{
				$model_spec->delete();
			}

			foreach($ProfileAnketaForm->usluga as $usluga)	{
				if(isset($ProfileAnketaForm->price[$usluga]))	{
					$userCategories = new UserSpecials();
					$userCategories->user_id = $model->id;
					$userCategories->category_id = $usluga;
					$userCategories->price = $ProfileAnketaForm->price[$usluga];
					$userCategories->save();
				}
			}
		}
	}
	
	//проверяем изменения в категориях
	public function checkCategories($model, $ProfileAnketaForm)
	{
		$array_identical = false;
		if(count($model->userCategories) != count($ProfileAnketaForm->categories)) {
			$array_identical = false;
		}	else	{
			foreach($model->userCategories as $item)	{
				$array_identical = false;
				foreach($ProfileAnketaForm->categories as $item1)	{
					if($item->category_id == $item1)
						$array_identical = true;
				}
			}
		}

		if($array_identical == false) {
			foreach($model->userCategories as $item)	{
				$item->delete();
			}

			foreach($ProfileAnketaForm->categories as $item)	{
				$userCategories = new UserCategories();
				$userCategories->user_id = $model->id;
				$userCategories->category_id = $item;
				$userCategories->save();
			}
		}
	}
	
	
	//проверяем изменения в наградах дипломах
	public function checkAwards($model, $ProfileAnketaForm)
	{
		$array_identical = false;
		if(count($model->media['awards']) != count($ProfileAnketaForm->awards)) {
			$array_identical = false;
		}	else	{
			foreach($model->media['awards'] as $item)	{
				$array_identical = false;
				foreach($ProfileAnketaForm->awards as $item1)	{
					if($item == $item1)
						$array_identical = true;
				}
			}
		}
		
		if($array_identical == false) {
			foreach($model->userMedia as $item)	{
				if($item->media_id == 1) {
					//перемещаем фото в temp
					if(file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['awards-path'].'/'.$item->filename))
						rename(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['awards-path'].'/'.$item->filename, Yii::getAlias('@frontend').'/web/tmp/'.$item->filename);

					if(file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['awards-path'].'/thumb_'.$item->filename))
						rename(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['awards-path'].'/'.'thumb_'.$item->filename, Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$item->filename);
					
					
					$item->delete();
				}
			}

			foreach($ProfileAnketaForm->awards as $award)	{
				$UserMedia = new UserMedia();
				$UserMedia->user_id = $model->id;
				$UserMedia->media_id = 1;
				$UserMedia->filename = $award;
				$UserMedia->save();
				
				//перемещаем фото
				if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.$award))
					rename(Yii::getAlias('@frontend').'/web/tmp/'.$award, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['awards-path'].'/'.$award);

				if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$award))
					rename(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$award, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['awards-path'].'/'.'thumb_'.$award);
			}
		}
	}
	
	//проверяем изменения в примерах работ
	public function checkExamples($model, $ProfileAnketaForm)
	{
		$array_identical = false;
		if(count($model->media['examples']) != count($ProfileAnketaForm->examples)) {
			$array_identical = false;
		}	else	{
			foreach($model->media['examples'] as $item)	{
				$array_identical = false;
				foreach($ProfileAnketaForm->examples as $item1)	{
					if($item == $item1)
						$array_identical = true;
				}
			}
		}
		
		if($array_identical == false) {
			foreach($model->userMedia as $item)	{
				if($item->media_id == 2) {
					//перемещаем фото в temp
					if(file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['examples-path'].'/'.$item->filename))
						rename(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['examples-path'].'/'.$item->filename, Yii::getAlias('@frontend').'/web/tmp/'.$item->filename);

					if(file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['examples-path'].'/thumb_'.$item->filename))
						rename(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['examples-path'].'/'.'thumb_'.$item->filename, Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$item->filename);
					
					
					$item->delete();
				}
			}

			foreach($ProfileAnketaForm->examples as $example) {
				$UserMedia = new UserMedia();
				$UserMedia->user_id = $model->id;
				$UserMedia->media_id = 2;
				$UserMedia->filename = $example;
				$UserMedia->save();

				//перемещаем фото
				if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.$example))
					rename(Yii::getAlias('@frontend').'/web/tmp/'.$example, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['examples-path'].'/'.$example);

				if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$example))
					rename(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$example, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['examples-path'].'/'.'thumb_'.$example);
			}
		}
	}
}
