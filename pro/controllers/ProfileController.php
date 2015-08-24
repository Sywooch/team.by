<?php

namespace pro\controllers;

use Yii;

use yii\helpers\Url;

use common\models\Category;
use common\models\User;
use common\models\UserCategories;
use common\models\UserSpecials;
use common\models\UserMedia;
use common\models\UserRegion;
use common\models\Notify;


use frontend\models\ProfileAnketaForm;
use frontend\models\ProfilePaymentTypeForm;


use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ProfileController extends Controller
{
	public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }	

    public function actionIndex()
	{
        //var_dump(\Yii::$app->user->isGuest);die;
		if (\Yii::$app->user->isGuest) {
            //return $this->goHome();
			return $this->redirect('/site/login');
        }
		
		$model = User::findOne(\Yii::$app->user->id);
		
		
		//если пользователя удалили через админку а он был залогинен в этот момент
		if($model->user_status == 3) {
			Yii::$app->user->logout();
			return $this->redirect('/site/login');
		}
		
		
		if($model->group_id != 2) return $this->render('no-spec');
		
		$ProfileAnketaForm = new ProfileAnketaForm();
		
		$ProfilePaymentTypeForm = ProfilePaymentTypeForm::findOne(\Yii::$app->user->id);

		//для коректной загрузки файлов аяксом
		//устанавливаем с какой моделью будем работать		
		Yii::$app->session->set('profile_model', 'ProfileAnketaForm');
		
		if ($ProfilePaymentTypeForm->load(Yii::$app->request->post())) {
			$ProfilePaymentTypeForm->save();
			//echo'<pre>';print_r($ProfilePaymentTypeForm);echo'</pre>';die;
			Yii::$app->session->setFlash('success', 'Метод оплаты обновлен.');
			$this->redirect('/profile');
		}
		//echo'<pre>1212121';print_r($ProfilePaymentTypeForm);echo'</pre>';die;
		//echo'<pre>';print_r(Yii::$app->request->post());echo'</pre>';//die;
		if ($ProfileAnketaForm->load(Yii::$app->request->post())) {
			
			foreach($ProfileAnketaForm->ratios as &$ratio) {
				$ratio = (double) str_replace(',', '.', $ratio);
				if($ratio == 0) $ratio = 1;
			}
			
			
			if($ProfileAnketaForm->email != $model->email) $ProfileAnketaForm->scenario = 'change_email';
			
			if($ProfileAnketaForm->validate()) {
				
				//echo'<pre>';print_r($ProfileAnketaForm);echo'</pre>';die;
			
				//echo'<pre>';var_dump($ProfileAnketaForm->ratios);echo'</pre>';die;

				if($ProfileAnketaForm->price_list != $model->price_list) {
					
					if($model->price_list != '') {
						//удаляем старый прайс-лист
						if(file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['pricelists-path'].'/'.$model->price_list))
							unlink(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['pricelists-path'].'/'.$model->price_list);
					}

					//перемещаем новый прайс-лист
					if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.$ProfileAnketaForm->price_list))
						rename(Yii::getAlias('@frontend').'/web/tmp/'.$ProfileAnketaForm->price_list, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['pricelists-path'].'/'.$ProfileAnketaForm->price_list);
				}

				if($ProfileAnketaForm->avatar != $model->avatar) {
					//удаляем старый аватар
					if($model->avatar != '' && file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['avatars-path'].'/'.$model->avatar))
						unlink(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['avatars-path'].'/'.$model->avatar);

					//перемещаем фото аватара
					if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.$ProfileAnketaForm->avatar))
						rename(Yii::getAlias('@frontend').'/web/tmp/'.$ProfileAnketaForm->avatar, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['avatars-path'].'/'.$ProfileAnketaForm->avatar);

					if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$ProfileAnketaForm->avatar))
						rename(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$ProfileAnketaForm->avatar, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['avatars-path'].'/'.'thumb_'.$ProfileAnketaForm->avatar);

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
				//echo'<pre>';print_r($model);echo'</pre>';die;
				Yii::$app->session->setFlash('success', 'Успешно сохранено.', false);
				//echo'<pre>';print_r(\Yii::$app->session->allFlashes);echo'</pre>';//die;
				$this->checkUslugi($model, $ProfileAnketaForm); //проверяем изменения в услугах

				$this->checkCategories($model, $ProfileAnketaForm); //проверяем изменения в категориях

				$this->checkAwards($model, $ProfileAnketaForm); //проверяем изменения в наградах дипломах

				$this->checkExamples($model, $ProfileAnketaForm); //проверяем изменения в примерах работ

				$this->checkRegions($model, $ProfileAnketaForm); //проверяем изменения в регионах
				
				//echo'<pre>';print_r(\Yii::$app->session->allFlashes);echo'</pre>';die;
				//echo'<pre>';print_r($model);echo'</pre>';die;			

				$this->redirect(Url::to(['/profile']));
			}	else	{
				Yii::$app->session->setFlash('error', 'Проверьте правильнось введенных данных');
				//echo'<pre>';print_r($ProfileAnketaForm);echo'</pre>';die;
			}
		}	else	{
			//echo'<pre>';print_r(Yii::$app->request->post());echo'</pre>';die;
			//echo'<pre>';print_r($ProfileAnketaForm);echo'</pre>';die;
			
			foreach($model->userRegions as $k=>$item)	{
				$ProfileAnketaForm->regions[] = $item->region_id;
				$ProfileAnketaForm->ratios[$k] = $item->ratio;
			}
			
			$ProfileAnketaForm->attributes = $model->toArray();
			
		}
		//echo'<pre>';print_r(\Yii::$app->session->allFlashes);echo'</pre>';//die;
		//echo'<pre>';var_dump($ProfileAnketaForm);echo'</pre>';die;
		
		
		
		foreach($model->userSpecials as $item)	{
			$ProfileAnketaForm->usluga[] = $item->category_id;
			$ProfileAnketaForm->price[$item->category_id] = $item->price ? $item->price : '';
			$ProfileAnketaForm->unit[$item->category_id] = $item->unit ? $item->unit : '';
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
				->orderBy('{{%order}}.'.$orderBy.' DESC'),
			
			'pagination' => [
				//'pageSize' => Yii::$app->params['catlist-per-page'],
				'pageSize' => 3,
				'pageSizeParam' => false,
				'pageParam' => 'o-page',
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
				'pageSize' => 2,
				'pageSizeParam' => false,
				'pageParam' => 'r-page',
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
		
	}
	
    public function actionDelete()
	{
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
		
		$model = User::findOne(Yii::$app->user->id);
		
		$model->user_status = 3;
		$model->save();
		
		Yii::$app->user->logout();
		/*
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
			
			Yii::$app->mailer->compose('mail-spec-change-status', ['model'=>$model, 'statusTxt'=>$model->userActivityList[$model->is_active]])
				->setTo(\Yii::$app->params['adminEmail'])
				->setFrom(\Yii::$app->params['noreplyEmail'])
				->setSubject('Пользователь сменил свой статус')
				->send();
			
			Yii::$app->session->setFlash('success', 'Текущий статус обновлен.');
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
		
		Yii::$app->session->setFlash('success', 'Время звонков обновлено.');
		
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

	public function actionDocuments()
	{
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
		
		$user = User::findOne(\Yii::$app->user->id);
		
		switch($user->user_type) {
			case 1:
				$document_form = 'DocumentsForm1';
				$model = new \frontend\models\DocumentsForm1();
				
				$model->passport_num = $user->passport_num;
				$model->passport_vidan = $user->passport_vidan;
				$model->passport_expire = $user->passport_expire;
				
				
				
				foreach($user->userDocuments as $doc) {
					switch($doc->document_id) {
						case 1:
							$model->passport_file = $doc->filename;
							break;
						case 2:
							$model->trud_file = $doc->filename;
							break;
						case 3:
							$model->diplom_file = $doc->filename;
							break;
						case 4:
							$model->other_file[] = $doc->filename;
							break;
					}
				}
				$tmpl = 'documents-1';
				break;
			case 2:
				$document_form = 'DocumentsForm2';
				$model = new \frontend\models\DocumentsForm2();
				
				$user_attr = $user->attributes;
				foreach($user_attr as $attr_key=>$attr)	{					
					if(isset($model->$attr_key))
						$model->$attr_key = $user->$attr_key;
				}
				
				if($model->contact_phone == '')
					$model->contact_phone = '+375';
				
				//$model->license = $user->license;
				//echo'<pre>';print_r($user);echo'</pre>';//die;
				//echo'<pre>';print_r($user_attr);echo'</pre>';//die;
				//echo'<pre>';print_r($model);echo'</pre>';die;
				
				foreach($user->userDocuments as $doc) {
					switch($doc->document_id) {
						case 5:
							$model->reg_file = $doc->filename;
							break;
						case 6:
							$model->bitovie_file = $doc->filename;
							break;
						case 7:
							$model->attestat_file = $doc->filename;
							break;
					}
				}
				
				
				$tmpl = 'documents-2';
				break;
			case 3:
				$document_form = 'DocumentsForm3';
				
				$model = new \frontend\models\DocumentsForm3();
				$model->license = $user->license;
				
				foreach($user->userDocuments as $doc) {
					switch($doc->document_id) {
						case 4:
							$model->other_file[] = $doc->filename;
							break;
						case 5:
							$model->reg_file = $doc->filename;
							break;
						case 6:
							$model->bitovie_file = $doc->filename;
							break;
					}
				}
				
				$tmpl = 'documents-3';
				break;
		}
		
		Yii::$app->session->set('document_form', $document_form);
        
		//echo'<pre>';print_r(Yii::$app->request->post());echo'</pre>';die;
        if ($model->load(Yii::$app->request->post())) {
			//echo'<pre>';print_r(Yii::$app->request->post());echo'</pre>';die;
			//echo'<pre>';print_r($model);echo'</pre>';die;
			if($model->validate()) {
				switch($user->user_type) {
					case 1:
						if($model->other_file[0] == '') unset($model->other_file[0]);
						$this->saveDocuments1($model, $user);
						break;
					case 2:
						$this->saveDocuments2($model, $user);
						break;
					case 3:
						if($model->other_file[0] == '') unset($model->other_file[0]);
						$this->saveDocuments3($model, $user);
						break;
				}
				
				$user->user_status = 2; //после редактирования меняем статус на "Требует проверки".
				$user->save();

				Yii::$app->session->setFlash('success', 'Сохранено.');

				return $this->redirect(['/profile/documents']);
			}
        }
		
		return $this->render($tmpl, [
			'model' => $model,
			'document_form' => $document_form,
		]);
		
		
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
				
				Yii::$app->mailer->compose('mail-spec-add-answer', ['model'=>$model])
					->setTo(\Yii::$app->params['adminEmail'])
					->setFrom(\Yii::$app->params['noreplyEmail'])
					->setSubject('Специалист прокомметировал отзыв')
					->send();
				
				Yii::$app->session->setFlash('success', 'Ответ успешно размещен. После проверки от будет опубликован');
				return $this->renderPartial('add-answer-modal-err', []);
			}
		}

		return $this->renderPartial('add-answer-modal', [
			'model' => $model,
		]);
	}	
    
	
	public function actionNotify()
	{
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
		
		$model = User::findOne(\Yii::$app->user->id);
		
		$DataProvider = new ActiveDataProvider([
			'query' => Notify::find()
				->where(['user_id'=>\Yii::$app->user->id])
				->orderBy('{{%notify}}.created_at DESC'),
			
			'pagination' => [
				//'pageSize' => Yii::$app->params['catlist-per-page'],
				'pageSize' => 200,
				'pageSizeParam' => false,
			],
		]);
		
		
		return $this->render('notify', [
			'model' => $model,
			'dataProvider' => $DataProvider,
		]);
		
	}
	
	public function actionSetReadedNotify($id)
	{
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
		
		$model = Notify::findOne($id);
		
		if($model === null)
			throw new NotFoundHttpException('Ошибка формирования уведомления');
		
		$model->readed = 1;
		$model->save();
		
		return $this->redirect(['/profile/notify']);
	}
		
	public function actionDeleteNotify($id)
	{
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
		
		$model = Notify::findOne($id);
		
		if($model === null)
			throw new NotFoundHttpException('Ошибка формирования уведомления');
		
		$model->delete();
		
		return $this->redirect(['/profile/notify']);
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
		
		//echo'<pre>';print_r($ProfileAnketaForm->usluga);echo'</pre>';//die;
		//echo'<pre>';print_r($ProfileAnketaForm->price);echo'</pre>';//die;
		//echo'<pre>';print_r($ProfileAnketaForm->unit);echo'</pre>';die;
		
		if(count($model->userSpecials) != count($ProfileAnketaForm->usluga)) {
			$array_identical = false;
		}	else	{			
			foreach($model->userSpecials as $model_spec)	{
				//echo'<pre>';print_r($model_spec);echo'</pre>';//die;
				$array_identical = false;
				foreach($ProfileAnketaForm->usluga as $key=>$usluga)	{
					if($model_spec->category_id == $usluga && $model_spec->price == $ProfileAnketaForm->price[$usluga] && $model_spec->unit == $ProfileAnketaForm->unit[$usluga])
						$array_identical = true;
				}
				
				if($array_identical === false) break;
			}
		}
		
		//echo'<pre>';var_dump($array_identical);echo'</pre>';die;
		//echo'<pre>';var_dump($ProfileAnketaForm->price);echo'</pre>';die;


		if($array_identical == false) {
			foreach($model->userSpecials as $model_spec)	{
				$model_spec->delete();
			}

			foreach($ProfileAnketaForm->usluga as $usluga)	{
				if(isset($ProfileAnketaForm->price[$usluga]))	{
					$userCategories = new UserSpecials();
					$userCategories->user_id = $model->id;
					$userCategories->category_id = $usluga;
					$userCategories->price = $ProfileAnketaForm->price[$usluga] ? (str_replace(' ', '', $ProfileAnketaForm->price[$usluga])) : 0;
					$userCategories->unit = $ProfileAnketaForm->unit[$usluga] ? $ProfileAnketaForm->unit[$usluga] : 0;
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
	
	//проверяем изменения в регионах
	public function checkRegions($model, $ProfileAnketaForm)
	{
		//echo'<pre>';print_r($ProfileAnketaForm->ratios);echo'</pre>';//die;
		$array_identical = false;
		if(count($model->userRegions) != count($ProfileAnketaForm->regions)) {
			$array_identical = false;
		}	else	{
			foreach($model->userRegions as $item)	{
				$array_identical = false;
				foreach($ProfileAnketaForm->regions as $k=>$item1)	{
					if($item->region_id == $item1 && $item->ratio == $ProfileAnketaForm->ratios[$k])
						$array_identical = true;					
				}
				if($array_identical === false) break;
			}
		}
		
		if($array_identical == false) {
			foreach($model->userRegions as $item)	{
				$item->delete();
			}

			foreach($ProfileAnketaForm->regions as $k=>$item)	{
				if($item != 0) {
					$userRegions = new UserRegion();
					$userRegions->user_id = $model->id;
					$userRegions->region_id = $item;
					$userRegions->ratio = $ProfileAnketaForm->ratios[$k];
					$userRegions->save();					
				}
			}
		}
	}
	
	public function saveDocuments1(&$model, &$user)
	{
		$user_attr = $user->attributes;
		foreach($user_attr as $attr_key=>&$attr)	{
			if(isset($model->$attr_key))
				$user->$attr_key = $model->$attr_key;
		}

		$user->save();
		//echo'<pre>';print_r($model);echo'</pre>';die;
		//echo'<pre>';print_r($user_attr);echo'</pre>';die;

		foreach($user->userDocuments as $item) {
			if(file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['documents-path'].'/'.$item->filename))
				rename(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['documents-path'].'/'.$item->filename, Yii::getAlias('@frontend').'/web/tmp/'.$item->filename);
		}

		$this->saveDocumentItem($model->passport_file, 1);

		$this->saveDocumentItem($model->trud_file, 2);

		$this->saveDocumentItem($model->diplom_file, 3);

		$this->checkOtherDocuments($model, $user->userDocuments);
	}
	
	public function saveDocuments2(&$model, &$user)
	{
		$user_attr = $user->attributes;
		
		if($user->license != '' && file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['licenses-path'].'/'.$user->license))
			rename(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['licenses-path'].'/'.$user->license, Yii::getAlias('@frontend').'/web/tmp/'.$user->license);
		
		foreach($user_attr as $attr_key=>&$attr)	{
			if(isset($model->$attr_key))
				$user->$attr_key = $model->$attr_key;
		}

		$user->save();
		
		if($user->license != '' && file_exists(Yii::getAlias('@frontend').'/web/tmp/'.$user->license))
			rename(Yii::getAlias('@frontend').'/web/tmp/'.$user->license, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['licenses-path'].'/'.$user->license);
		
		//echo'<pre>';print_r($model);echo'</pre>';die;
		foreach($user->userDocuments as $item) {
			if(file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['documents-path'].'/'.$item->filename))
				rename(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['documents-path'].'/'.$item->filename, Yii::getAlias('@frontend').'/web/tmp/'.$item->filename);
		}

		
		
		$this->saveDocumentItem($model->reg_file, 5);

		$this->saveDocumentItem($model->bitovie_file, 6);
		
		$this->saveDocumentItem($model->attestat_file, 7);
	}
	
	public function saveDocuments3(&$model, &$user)
	{
		$user_attr = $user->attributes;

		if($user->license != '' && file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['licenses-path'].'/'.$user->license))
			rename(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['licenses-path'].'/'.$user->license, Yii::getAlias('@frontend').'/web/tmp/'.$user->license);
		
		
		foreach($user_attr as $attr_key=>&$attr)	{
			if(isset($model->$attr_key))
				$user->$attr_key = $model->$attr_key;
		}

		//echo'<pre>';print_r($user->license);echo'</pre>';die;
		$user->save();
		
		if($user->license != '' && file_exists(Yii::getAlias('@frontend').'/web/tmp/'.$user->license))
			rename(Yii::getAlias('@frontend').'/web/tmp/'.$user->license, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['licenses-path'].'/'.$user->license);

		foreach($user->userDocuments as $item) {
			if(file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['documents-path'].'/'.$item->filename))
				rename(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['documents-path'].'/'.$item->filename, Yii::getAlias('@frontend').'/web/tmp/'.$item->filename);
		}

		$this->saveDocumentItem($model->reg_file, 5);

		$this->saveDocumentItem($model->bitovie_file, 6);

		$this->checkOtherDocuments($model, $user->userDocuments);
	}
	
	public function saveDocumentItem($filename, $doc_id)
	{
		$UserDocuments = \common\models\UserDocuments::find()
			->where(['document_id'=>$doc_id])
			->andWhere(['user_id'=>\Yii::$app->user->id])
			->one();
			//echo'<pre>';var_dump($filename);echo'</pre>';die;
			//echo'<pre>';var_dump($UserDocuments);echo'</pre>';die;

		if($filename != '') {
			if($UserDocuments === NULL) {
				$UserDocuments = new \common\models\UserDocuments();
				$UserDocuments->user_id = \Yii::$app->user->id;
				$UserDocuments->document_id = $doc_id;
			}
			$UserDocuments->filename = $filename;
			$UserDocuments->save();

			//echo'<pre>';print_r($UserDocuments);echo'</pre>';die;

			if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.$filename))
				rename(Yii::getAlias('@frontend').'/web/tmp/'.$filename, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['documents-path'].'/'.$filename);

			if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$filename))
				rename(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$filename, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['documents-path'].'/'.'thumb_'.$filename);
		}	else	{
			if($UserDocuments != NULL)
				$UserDocuments->delete();
		}
	}
	
	//проверяем изменения в примерах работ
	public function checkOtherDocuments($model, $userDocuments)
	{
		
		$userDocuments1 = [];
		
		foreach($userDocuments as $key=>$doc)
			if($doc->document_id == 4)
				$userDocuments1[] = $doc;
			
		$userDocuments = $userDocuments1;
			
		$array_identical = false;
		if(count($model->other_file) != count($userDocuments)) {
			$array_identical = false;
		}	else	{
			foreach($model->other_file as $item)	{
				$array_identical = false;
				foreach($userDocuments as $item1)	{
					if($item == $item1->filename)
						$array_identical = true;
				}
				if($array_identical === false) break;
			}
		}
		
		//echo'<pre>';var_dump($array_identical);echo'</pre>';die;
		
		if($array_identical == false) {
			foreach($userDocuments as $item)	{
				if($item->document_id == 4) {
					//перемещаем фото в temp
					if(file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['documents-path'].'/'.$item->filename))
						rename(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['documents-path'].'/'.$item->filename, Yii::getAlias('@frontend').'/web/tmp/'.$item->filename);

					if(file_exists(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['documents-path'].'/thumb_'.$item->filename))
						rename(Yii::getAlias('@frontend').'/web/'.Yii::$app->params['documents-path'].'/'.'thumb_'.$item->filename, Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$item->filename);

					$item->delete();
				}
			}

			foreach($model->other_file as $filename) {
				if($filename != '') {
					$UserDocuments = new \common\models\UserDocuments();
					$UserDocuments->user_id = \Yii::$app->user->id;
					$UserDocuments->document_id = 4;
					$UserDocuments->filename = $filename;
					$UserDocuments->save();

					//перемещаем фото
					if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.$filename))
						rename(Yii::getAlias('@frontend').'/web/tmp/'.$filename, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['documents-path'].'/'.$filename);

					if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$filename))
						rename(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$filename, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['documents-path'].'/'.'thumb_'.$filename);
				}
			}
		}	else	{
			foreach($userDocuments as $item)	{
				if($item->document_id == 4) {
					//перемещаем фото в temp
					if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.$item->filename))
						rename(Yii::getAlias('@frontend').'/web/tmp/'.$item->filename, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['documents-path'].'/'.$item->filename);

					if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$item->filename))
						rename(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$item->filename, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['documents-path'].'/'.'thumb_'.$item->filename);
				}
			}
			
		}
	}
	
}
