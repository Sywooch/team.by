<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use common\models\Category;

use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\RegStep1Form;
use frontend\models\RegStep2Form;
use frontend\models\ZakazSpec1;
use frontend\models\ZakazSpec2;

use common\models\User;
use common\models\UserCategories;
use common\models\UserSpecials;
use common\models\UserMedia;
use common\models\Region;


use yii\base\InvalidParamException;

use yii\web\BadRequestHttpException;
use yii\web\Controller;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\web\Cookie;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
					
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

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

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
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

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

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionReg()
    {
        return $this->render('reg', []);
    }
	
	public function actionRegStep1()
	{
		$model = new RegStep1Form();

		if ($model->load(Yii::$app->request->post())) {
			//echo'<pre>';print_r(Yii::$app->request->post());echo'</pre>';//die;
			//echo'<pre>';print_r($model);echo'</pre>';die;
			if ($model->validate()) {
				//echo'<pre>';print_r(Yii::$app->request->post());echo'</pre>';die;
				
				Yii::$app->response->cookies->add(new \yii\web\Cookie([
					'name' => 'RegStep1Form',
					'value' => json_encode(Yii::$app->request->post()['RegStep1Form']),
				]));
				
				return $this->redirect(['reg-step2']);
			}
		}

		return $this->render('reg-step1', [
			'model' => $model,
		]);
	}	

	public function actionRegStep2()
	{
		$model = new RegStep2Form();
		
		$RegStep1Form = json_decode(Yii::$app->request->cookies->getValue('RegStep1Form'), 1);
		if(count($RegStep1Form) == 0)
			return $this->redirect(['reg-step1']);
		
		//для кооректной загрузки файлов аяксом
		//устанавливаем с какой моделью будем работать
		Yii::$app->session->set('profile_model', 'RegStep2Form');	
		
		//if(count(Yii::$app->request->post()))
			
		//echo'<pre>';print_r(Yii::$app->request->post());echo'</pre>';//die;
		if ($model->load(Yii::$app->request->post())) {
			
			$region_ok = 1;
			//если нужно - добавляем новый город
			if($model->region_name != '') {
				$parent_region = Region::findOne($model->region_parent_id);
				if($parent_region === null) {
					Yii::$app->getSession()->setFlash('error', 'Ошибка при добавлении нового региона');
					$region_ok = 0;
				}	else	{
					$new_region = new Region();
					$new_region->name = $model->region_name;
					$new_region->parent_id = $model->region_parent_id;
					$new_region->appendTo($parent_region);
				}
			}
			
			
			if ($model->validate() && $region_ok == 1) {
				$RegStep1Form = json_decode(Yii::$app->request->cookies->getValue('RegStep1Form'), 1);
				$RegStep2Form = $model;
				//echo'<pre>';print_r(Yii::$app->request->post());echo'</pre>';//die;
				//echo'<pre>';print_r($model);echo'</pre>';//die;
				//echo'<pre>';print_r($RegStep2Form);echo'</pre>';
				//die;
				
				
				//создаем поьзователя
				$user = new User();
				$user->username = $RegStep1Form['email'];	//у нас вторизация по мейлу
				$user->email = $RegStep1Form['email'];
				
				$user->group_id = 2;
				$user->user_type = $RegStep1Form['user_type'];
				$user->fio = $RegStep1Form['fio'];
				$user->phone = $RegStep1Form['phone'];
				$user->region_id = $RegStep2Form['region'];
				$user->about = $RegStep2Form['about'];
				$user->education = $RegStep2Form['education'];
				$user->experience = $RegStep2Form['experience'];
				
				$user->price_list = $RegStep2Form['price_list'];
				$user->avatar = $RegStep2Form['avatar'];				
				
				$user->setPassword($RegStep1Form['password']);
				$user->generateAuthKey();
				$user->save();
				
				//перемещаем фото аватара
				if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.$RegStep2Form['avatar']))
					rename(Yii::getAlias('@frontend').'/web/tmp/'.$RegStep2Form['avatar'], Yii::getAlias('@frontend').'/web/'.Yii::$app->params['avatars-path'].'/'.$RegStep2Form['avatar']);
				
				if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$RegStep2Form['avatar']))
					rename(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$RegStep2Form['avatar'], Yii::getAlias('@frontend').'/web/'.Yii::$app->params['avatars-path'].'/'.'thumb_'.$RegStep2Form['avatar']);
				
				if($RegStep2Form['price_list'] != '') {
					//перемещаем прайс-лист
					if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.$RegStep2Form['price_list']))
						rename(Yii::getAlias('@frontend').'/web/tmp/'.$RegStep2Form['price_list'], Yii::getAlias('@frontend').'/web/'.Yii::$app->params['pricelists-path'].'/'.$RegStep2Form['price_list']);
				}
				
				//назначаем ему категории
				foreach($RegStep2Form->categories as $cat) {
					$userCategories = new UserCategories();
					$userCategories->user_id = $user->id;
					$userCategories->category_id = $cat;
					//$userCategories->price = $RegStep2Form->price[$cat];
					$userCategories->save();
				}
				
				//назначаем ему специализации
				foreach($RegStep2Form->usluga as $k=>$p) {
					if(isset($RegStep2Form->price[$p])) {
						$userCategories = new UserSpecials();
						$userCategories->user_id = $user->id;
						$userCategories->category_id = $k;
						$userCategories->price = $RegStep2Form->price[$p];
						$userCategories->save();
					}
				}
				
				//добавляем награды, дипломы
				foreach($RegStep2Form->awards as $award) {
					$UserMedia = new UserMedia();
					$UserMedia->user_id = $user->id;
					$UserMedia->media_id = 1;
					$UserMedia->filename = $award;
					$UserMedia->save();
					
					//перемещаем фото
					if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.$award))
						rename(Yii::getAlias('@frontend').'/web/tmp/'.$award, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['awards-path'].'/'.$award);
					
					if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$award))
						rename(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$award, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['awards-path'].'/'.'thumb_'.$award);
				}
				
				//добавляем примеры работ
				foreach($RegStep2Form->examples as $example) {
					$UserMedia = new UserMedia();
					$UserMedia->user_id = $user->id;
					$UserMedia->media_id = 2;
					$UserMedia->filename = $example;
					$UserMedia->save();
					
					//перемещаем фото
					if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.$example))
						rename(Yii::getAlias('@frontend').'/web/tmp/'.$example, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['examples-path'].'/'.$example);
					
					if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$example))
						rename(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$example, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['examples-path'].'/'.'thumb_'.$example);
				}
				
				Yii::$app->response->cookies->remove('RegStep1Form');
				
				return $this->redirect(['reg-final']);
			}
		}
		
		//echo'<pre>';print_r($model);echo'</pre>';//die;
		
		$categories = Category::find()->where('id <> 1')->orderBy('lft, rgt')->all();
		
		$cats_l1 = [];
		$cats_l3 = [];

		foreach($categories as $c){
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
		
		//echo'<pre>';print_r($cats_l3);echo'</pre>';//die;
		

		return $this->render('reg-step2', [
			'model' => $model,
			'categories' => $cats_l1,
			'categories_l3' => $cats_l3,
		]);
	}
	
	
	public function actionRegFinal()
	{
		return $this->render('reg-final', [
		]);
	}	

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
		
		$request = Yii::$app->request;
		$modal = $request->get('modal');
		
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Инструкции высланы на Ваш e-mail.');
				if($modal == 1) {
					return $this->renderPartial('requestPasswordResetToken-success-modal', [
						'model' => $model,
					]);
				}	else	{
					return $this->goHome();
				}

            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }
		
		if($modal == 1) {
			return $this->renderPartial('requestPasswordResetToken-modal', [
				'model' => $model,
			]);
		}	else	{
			return $this->render('requestPasswordResetToken', [
				'model' => $model,
			]);
		}
		
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'Новый пароль сохранён.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
	
    public function actionSetRegion()
    {
		$return_url = (string) Yii::$app->request->post('return_url', '');
		$region_id = (int) Yii::$app->request->post('region_id', 0);
		
		if($return_url == '' || $region_id == 0) {
			return $this->goHome();
		}	else	{
			
			$cookie = new Cookie([
				'name' => 'region',
				'value' => $region_id,
				'expire' => time() + 86400 * 365,
			]);
			
			\Yii::$app->getResponse()->getCookies()->add($cookie);
			
			return $this->redirect($return_url);
		}
    }
	
    public function actionSetCurrency()
    {
		$return_url = (string) Yii::$app->request->post('return_url', '');
		$currency_id = (int) Yii::$app->request->post('currency_id', 0);
		
		if($return_url == '' || $currency_id == 0) {
			return $this->goHome();
		}	else	{
			
			$cookie = new Cookie([
				'name' => 'currency',
				'value' => $currency_id,
				'expire' => time() + 86400 * 365,
			]);
			
			\Yii::$app->getResponse()->getCookies()->add($cookie);
			
			return $this->redirect($return_url);
		}
    }
	
	public function actionZakazSpec1()
	{
		$model = new ZakazSpec1();
		
		$request = Yii::$app->request;
		$modal = $request->get('modal');		

		if ($model->load(Yii::$app->request->post())) {
			if ($model->validate()) {
				Yii::$app->session['zakaz-spec1'] = Yii::$app->request->post()['ZakazSpec1'];
				$model = new ZakazSpec2();
				// form inputs are valid, do something here
				if($modal == 1)	{
					return $this->renderPartial('zakaz-spec2-modal', [
						'model' => $model,
					]);			

				}	else	{
					return $this->redirect('/site/zakaz-spec2');
				}
			}
		}
		
		if($modal == 1)	{
			return $this->renderPartial('zakaz-spec1-modal', [
				'model' => $model,
			]);			
		}	else	{
			return $this->render('zakaz-spec1', [
				'model' => $model,
			]);
			
		}

	}
	
	public function actionZakazSpec2()
	{
		$model = new ZakazSpec2();
		
		$request = Yii::$app->request;
		$modal = $request->get('modal');

		if ($model->load(Yii::$app->request->post())) {
			if ($model->validate()) {
				$model->name = Yii::$app->session['zakaz-spec1']['name'];
				$model->phone = Yii::$app->session['zakaz-spec1']['phone'];
				$model->comment = Yii::$app->session['zakaz-spec1']['comment'];
				if($model->sendEmail(Yii::$app->params['adminEmail'])) {
					Yii::$app->getSession()->setFlash('success', 'Мы получили Вашу заявку.');
				}	else	{
					Yii::$app->getSession()->setFlash('error', 'При отправке сообщения возникла ошибка');
				}
				
				unset(Yii::$app->session['zakaz-spec1']);
				
				if($modal == 1)	{
					return $this->renderPartial('sending-mail-result-modal', [
						'title' => 'Заявка на подбор профессионала',
					]);					
					
				}	else	{
					return $this->render('zakaz-spec2', [
						'model' => $model,
					]);					
				}
				
			}
		}

		if($modal == 1)	{
			return $this->renderPartial('zakaz-spec2-modal', [
				'model' => $model,
			]);			
		}	else	{
			return $this->render('zakaz-spec2', [
				'model' => $model,
			]);
			
		}
	}
	
	
	public function actionNewReview()
	{
		$model = new \frontend\models\AddReviewForm();
		
		$request = Yii::$app->request;
		$modal = $request->get('modal');
		

		if ($model->load(Yii::$app->request->post())) {
			if ($model->validate()) {
				//echo'<pre>';print_r(Yii::$app->request->post());echo'</pre>';die;
				$client = \common\models\Client::find()->where(['phone' => $model->phone])->one();
				if($client === null) {
					Yii::$app->getSession()->setFlash('error', 'Клиент с заданым телефоном не найден');
				}	else	{
					$order = \common\models\Order::find()
								->where(['client_id' => $client->id])
								->andWhere(['user_id' => $model->user_id])
								->one();
					if($order === null) {
						Yii::$app->getSession()->setFlash('error', 'Заказ не найден');
					}	else	{
						
						$review = \common\models\Review::find()
									->where(['client_id' => $client->id])
									->andWhere(['order_id' => $order->id])
									->one();
						//echo'<pre>';print_r($review);echo'</pre>';//die;
						if($review === null) {
							$review = new \common\models\Review();

							$model_attribs = $model->toArray();
							$review_attr = $review->attributes;
							//echo'<pre>';print_r($model_attribs);echo'</pre>';//die;
							//echo'<pre>';print_r($review_attr);echo'</pre>';//die;

							
							$review->order_id = $order->id;
							$review->client_id = $client->id;
							$review->user_id = $model->user_id;
							$review->review_text = $model->comment;
							$review->review_rating = $model->rating;
							$review->youtube = $model->video;
							$review->status = 0;
							
							if($review->validate()) {
								$review->save();

								foreach($model->foto as $foto) {
									$ReviewMedia = new \common\models\ReviewMedia();
									$ReviewMedia->review_id = $review->id;
									$ReviewMedia->filename = $foto;
									if($ReviewMedia->save())	{
										//перемещаем фото
										if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.$foto))
											rename(Yii::getAlias('@frontend').'/web/tmp/'.$foto, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['reviews-path'].'/'.$foto);

										if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$foto))
											rename(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$foto, Yii::getAlias('@frontend').'/web/'.Yii::$app->params['reviews-path'].'/'.'thumb_'.$foto);
									}
								}
								
								Yii::$app->getSession()->setFlash('success', 'Благодарим вас за отзыв! Ваш отзыв появится на сайте сразу же после проверки модератором.');
							}	else	{
								//echo'<pre>';print_r($review);echo'</pre>';//die;
								Yii::$app->getSession()->setFlash('error', 'Ошибка при сохранении отзыва');
							}
						}	else	{
							Yii::$app->getSession()->setFlash('error', 'Для данного заказа отзыв уже оставлен');
						}
					}
					
				}
				//echo'<pre>';print_r($order);echo'</pre>';die;				
				//return;
			}
		}
		
		if($modal == 1) {
			return $this->renderPartial('new-review-modal', [
				'model' => $model,
			]);
		}	else	{
			return $this->render('new-review', [
				'model' => $model,
			]);
		}
	}	
}
