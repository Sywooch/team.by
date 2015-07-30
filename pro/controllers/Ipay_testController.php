<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use yii\helpers\Url;

class Ipay_testController extends Controller
{
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
        echo'<pre>';print_r($_SERVER);echo'</pre>';
		return $this->render('index');
    }

    public function actionPay($id)
    {
		
// https://.../!iSOU.Login?srv_no=...&pers_acc=...& amount=...&amount_editable=...&provider_url=...		
		//echo $id;
		
		$order = \app\models\Order::findOne($id);
		if ($order === null) {
			\Yii::$app->session->setFlash('error', 'При сохранении возникла ошибка');
			return $this->render('pay-error');
		}
		
		$IpayForm = new \app\models\IpayForm();
		$IpayForm->srv_no = '123';
		$IpayForm->pers_acc = $order->id;
		$IpayForm->amount = $order->price;
		$IpayForm->amount_editable = 'N';
		$IpayForm->provider_url = Url::to(['ipay_test/return']);
		
		
		
        return $this->render('pay', [
			'model'=>$IpayForm,
			'orderNum'=>$id,
		]);
    }

    public function actionService_info()
    {
		// Константа для подписи запросов
		
		$salt = addslashes('2134234fasdasd');
		/*
		$xml_test = '<?xml version="1.0" encoding="windows-1251" ?>
<ServiceProvider_Request>
<Version>1</Version>
<RequestType>ServiceInfo</RequestType>
<DateTime>20090124153456</DateTime>
<PersonalAccount>123</PersonalAccount>
<Currency>974</Currency>
<RequestId>9221</RequestId>
<ServiceInfo>
<Agent>999</Agent>
</ServiceInfo >
</ServiceProvider_Request>';
	*/
		//if(isset($_POST['XML'])) {
			//$xml = new \SimpleXMLElement($_POST['XML']);
			//$xml = new \SimpleXMLElement($xml_test);
			$filename = $_SERVER['DOCUMENT_ROOT'] . '/xml.log';
			if(isset($_POST['XML'])) {
				$mytext = Yii::$app->formatter->asDate(time(), 'php:d-m-yy G:i:s'). ' - есть xml';	
			} else {
				$mytext = Yii::$app->formatter->asDate(time(), 'php:d-m-yy G:i:s'). ' - нет xml';	
			}
			//echo'11212<pre>';var_dump($xml->RequestType);echo'</pre>';
			//$xml->ServiceProvider_Request->RequestType

			$fp = fopen($filename, "w"); // Открываем файл в режиме записи 
			//$mytext = time().$xml->RequestType;
			//$mytext = Yii::$app->formatter->asDate(time(), 'php:d-m-yy G:i:s').$_POST['XML'];
			fwrite($fp, $mytext); // Запись в файл
			//if ($test) echo 'Данные в файл успешно занесены.';
			//else echo 'Ошибка при записи в файл.';
			fclose($fp); //Закрытие файла
		//}
		echo '1111';
		exit();


		
		
        return $this->render('service-info');
    }

    public function actionTransaction_start()
    {
        return $this->render('transaction-start');
    }

    public function actionTransaction_result()
    {
        return $this->render('transaction-result');
    }
}
