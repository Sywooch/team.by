<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class IpayController extends Controller
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
        return $this->render('index');
    }

    public function actionService_info()
    {
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
			//if(isset($_POST['XML'])) {
			if(isset($_POST['XML'])) {
				$mytext = time(). 'есть';	
			} else {
				$mytext = time(). 'нет';	
			}
			//echo'11212<pre>';var_dump($xml->RequestType);echo'</pre>';
			//$xml->ServiceProvider_Request->RequestType

			$fp = fopen($filename, "w"); // Открываем файл в режиме записи 
			//$mytext = time().$xml->RequestType;
			//$mytext = time().$_POST['XML'];
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
