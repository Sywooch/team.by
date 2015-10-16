<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use common\models\UserToAdministration;

use yii\filters\VerbFilter;

use yii\base\InvalidParamException;

use yii\web\BadRequestHttpException;


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
                'rules' => [
                    [
                        'actions' => ['index', 'login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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
		$this->chekUserAdminOrManager();
		$UserToAdministration = new UserToAdministration();
		
        return $this->render('index', ['unreadMessages' => $UserToAdministration->unreadMessages]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
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
	
    public function chekUserAdminOrManager()
    {
		if (\Yii::$app->user->isGuest) {
			return $this->redirect('site/login'); 
		}
		
        $user = \common\models\User::findOne(Yii::$app->user->id);
		
		if($user->group_id != 1) {
			throw new \yii\web\ForbiddenHttpException('У вас нет доступа к данной странице');
		}
    }
	
	
}
