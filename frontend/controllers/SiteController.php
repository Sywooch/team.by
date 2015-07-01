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
			if ($model->validate()) {
				// form inputs are valid, do something here
				return;
			}
		}

		return $this->render('reg-step1', [
			'model' => $model,
		]);
	}	

	public function actionRegStep2()
	{
		$model = new RegStep2Form();
		
		//echo'<pre>';print_r(Yii::$app->request->post());echo'</pre>';die;

		if ($model->load(Yii::$app->request->post())) {
			if ($model->validate()) {
				// form inputs are valid, do something here
				return;
			}
		}
		
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
		

		return $this->render('reg-step2', [
			'model' => $model,
			'categories' => $cats_l1,
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
}
