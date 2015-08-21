<?php

namespace pro\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

use common\models\LoginForm;
use common\models\Category;

use common\models\User;
use common\models\UserCategories;
use common\models\UserSpecials;
use common\models\UserMedia;
use common\models\Region;
use common\models\UserRegion;

use frontend\models\RegStep1Form;
use frontend\models\RegStep2Form;


use app\models\ContactForm;
//use app\models\ProfileAnketaForm;
//use app\models\ProfilePaymentTypeForm;

use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;

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
		return $this->render('index', []);
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
//			if($model->region_name != '') {
//				$parent_region = Region::findOne($model->region_parent_id);
//				if($parent_region === null) {
//					Yii::$app->getSession()->setFlash('error', 'Ошибка при добавлении нового региона');
//					$region_ok = 0;
//				}	else	{
//					$new_region = new Region();
//					$new_region->name = $model->region_name;
//					$new_region->parent_id = $model->region_parent_id;
//					$new_region->appendTo($parent_region);
//				}
//			}
			foreach($model->ratios as &$ratio) {
				$ratio = (double) str_replace(',', '.', $ratio);
				if($ratio == 0) $ratio = 1;
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
				//$user->region_id = $RegStep2Form['region'];
				$user->about = $RegStep2Form['about'];
				$user->education = $RegStep2Form['education'];
				$user->experience = $RegStep2Form['experience'];
				
				$user->price_list = $RegStep2Form['price_list'];
				$user->avatar = $RegStep2Form['avatar'];				
				$user->youtube = $RegStep2Form['youtube'];				
				//$user->license = $RegStep2Form['license'];				
				
				$user->setPassword($RegStep1Form['password']);
				$user->generateAuthKey();
				$user->save();
				
				//перемещаем фото аватара
				if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.$RegStep2Form['avatar']))
					rename(Yii::getAlias('@frontend').'/web/tmp/'.$RegStep2Form['avatar'], Yii::getAlias('@frontend').'/web/'.Yii::$app->params['avatars-path'].'/'.$RegStep2Form['avatar']);
				
				if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$RegStep2Form['avatar']))
					rename(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$RegStep2Form['avatar'], Yii::getAlias('@frontend').'/web/'.Yii::$app->params['avatars-path'].'/'.'thumb_'.$RegStep2Form['avatar']);
				
				if($RegStep2Form['license'] != '') {
					//перемещаем файл лицензии
					if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.$RegStep2Form['license']))
						rename(Yii::getAlias('@frontend').'/web/tmp/'.$RegStep2Form['license'], Yii::getAlias('@frontend').'/web/'.Yii::$app->params['licenses-path'].'/'.$RegStep2Form['license']);
				}
				
				if(file_exists(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$RegStep2Form['license']))
					rename(Yii::getAlias('@frontend').'/web/tmp/'.'thumb_'.$RegStep2Form['license'], Yii::getAlias('@frontend').'/web/'.Yii::$app->params['licenses-path'].'/'.'thumb_'.$RegStep2Form['license']);
				
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
					//if(isset($RegStep2Form->price[$p])) {
						$userCategories = new UserSpecials();
						$userCategories->user_id = $user->id;
						$userCategories->category_id = $p;
						$userCategories->price = $RegStep2Form->price[$p] ? $RegStep2Form->price[$p] : 0;
						$userCategories->save();
					//}
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
				
				foreach($RegStep2Form->regions as $k=>$item)	{
					$userRegions = new UserRegion();
					$userRegions->user_id = $user->id;
					$userRegions->region_id = $item;
					$userRegions->ratio = $RegStep2Form->ratios[$k];
					$userRegions->save();
				}
				
				//echo'<pre>';print_r($user->getId());echo'</pre>';//die;
				//echo'<pre>';print_r($user->id);echo'</pre>';//die;
				
				//назначаем нужный уровень доступа
				//$name_of_role = 'specialist';
				//$userRole = Yii::$app->authManager->getRole($name_of_role);
				//Yii::$app->authManager->assign($userRole, $user->id);
				
				Yii::$app->response->cookies->remove('RegStep1Form');
				
				Yii::$app->mailer->compose('mail-new-spec', ['user'=>$user])
					->setTo(\Yii::$app->params['adminEmail'])
					->setFrom(\Yii::$app->params['noreplyEmail'])
					->setSubject('Регистрация нового специалиста')
					->send();
				
				Yii::$app->mailer->compose('mail-new-spec-reg', ['model'=>$RegStep1Form])
					->setTo($RegStep1Form['email'])
					->setFrom(\Yii::$app->params['noreplyEmail'])
					->setSubject('Регистрация нового специалиста')
					->send();
				
				Yii::$app->user->login($user, 0);
				
				return $this->redirect(['reg-final']);
			}	else	{
				//echo'<pre>';print_r($model);echo'</pre>';//die;
			}
		}
		
		
		
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
		
		if(count($model->ratios) == 0) $model->ratios[] = 1;	//нужно чтобы у первого городоа коэф был 1.
		
		//echo'<pre>';print_r($model->ratios);echo'</pre>';//die;
		
		

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
        $model = new \frontend\models\PasswordResetRequestForm();
		
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
					//return $this->goHome();
				}

            } else {
                Yii::$app->getSession()->setFlash('error', 'Ошибка отправки почты');
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
            $model = new \frontend\models\ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'Новый пароль сохранен.');
            return $this->redirect(Yii::$app->params['proUrl']);
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
	
}
