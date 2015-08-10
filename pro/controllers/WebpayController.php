<?php

namespace pro\controllers;

use Yii;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\web\Controller;


use yii\helpers\Html;

use common\models\Order;

//use app\models\LoginForm;
//use app\models\ContactForm;



class WebpayController extends Controller
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
			/*
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
			*/
        ];
    }
	
    public function beforeAction($action) {
        //$this->enableCsrfValidation = ($action->id !== "reg-step2-upload-price"); 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action);
    }		

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPay($id)
    {
		$order = Order::findOne($id);
		
		if ($order === null) 
			return $this->renderPayError('Заказ не найден');
		
		if ($order->payment_status == 10 || $order->tid != '') 
			return $this->renderPayError('Данный заказ уже оплачен');
		
		if ($order->fee == 0) 
			return $this->renderPayError('Отсутствует сумма для оплаты');
		
        return $this->render('pay', ['order'=>$order]);
    }

    public function actionComplete()
    {
		$wsb_order_num = Html::encode(Yii::$app->request->get('wsb_order_num', ''));
		$wsb_tid = Html::encode(Yii::$app->request->get('wsb_tid', ''));
		
		if($wsb_order_num == '' || $wsb_tid == '') {
			\Yii::$app->session->setFlash('error', 'Отсутствуют необходимые параметры');
			return $this->render('pay-error');			
		}
		
		
		$params = \Yii::$app->params['payment_systems']['webpay'];
		
		$postdata = '*API=&API_XML_REQUEST='.urlencode('
		<?xml version="1.0" encoding="ISO-8859-1" ?>
		<wsb_api_request>
		<command>get_transaction</command>
		<authorization>
		<username>'.$params['wsb_username'].'</username>
		<password>'.(md5($params['wsb_password'])).'</password>
		</authorization>
		<fields>
		<transaction_id>'.$wsb_tid.'</transaction_id>
		</fields>
		</wsb_api_request>
		');
		
		$curl = curl_init ($params['wsb_test'] ? $params['wsb_url_test_check_trans'] : $params['wsb_url_check_trans']);
		//$curl = curl_init ('https://sandbox.webpay.by');
		curl_setopt ($curl, CURLOPT_HEADER, 0);
		curl_setopt ($curl, CURLOPT_POST, 1);
		curl_setopt ($curl, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, 0);
		$response = curl_exec ($curl);
		curl_close ($curl);
		//echo $response;
		
		$xml = new \SimpleXMLElement($response);
		
		$status = (string) $xml->status[0];
		
		if($status == 'failed') {
			\Yii::$app->session->setFlash('error', 'Ошибка обработки платежа');
			return $this->render('pay-error');			
		}
		
		foreach($xml->fields as $field) {
			$transaction_id = (string) $field->transaction_id;
			$batch_timestamp = (string) $field->batch_timestamp;
			$currency_id = (string) $field->currency_id;
			$amount = (string) $field->amount;
			$payment_method = (string) $field->payment_method;
			$payment_type = (string) $field->payment_type;
			$order_id = (string) $field->order_id;
			$rrn = (string) $field->rrn;
			$wsb_signature_get = (string) $field->wsb_signature;
		}
		
		$wsb_signature = md5($transaction_id . $batch_timestamp . $currency_id . $amount . $payment_method . $payment_type . $order_id . $rrn . $params['SecretKey']);
		
		if($wsb_signature != $wsb_signature_get) {
			\Yii::$app->session->setFlash('error', 'Ошибка обработки платежа');
			return $this->render('pay-error');
		}
				
		$order = Order::findOne($wsb_order_num);
		if ($order === null) {
			\Yii::$app->session->setFlash('error', 'Заказ не существует');
			return $this->render('pay-error');
		}
		if($order->payment_status != 10) {
			$order->status = 4;
			$order->payment_status = 10;
			$order->pay_system = 1;
			$order->tid = $wsb_tid;
			$order->payed_at = time();
			$order->save();
		}
		
		Yii::$app->mailer->compose('mail-payment-notice-manager', ['order'=>$order])
			->setTo(\Yii::$app->params['adminEmail'])
			->setFrom(\Yii::$app->params['noreplyEmail'])
			->setSubject('Оплата заказа')
			->send();

		Yii::$app->mailer->compose('mail-payment-notice-user', ['order'=>$order])
			->setTo($order->user->email)
			->setFrom(\Yii::$app->params['noreplyEmail'])
			->setSubject('Оплата заказа')
			->send();
		
		
		\Yii::$app->session->setFlash('success', 'Заказ успешно оплачен');
		
        return $this->render('complete', ['order'=>$order]);
    }

    public function actionCancel()
    {
		\Yii::$app->session->setFlash('error', 'Оплата отменена');
		return $this->render('pay-error');
    }

    public function actionNotify()
    {
		$filename = $_SERVER['DOCUMENT_ROOT'] . '/webpay.log';
		$mytext = Yii::$app->formatter->asDate(time(), 'php:d-m-yy G:i:s'). " - webpay notify \n";

		$fp = fopen($filename, "a+"); // Открываем файл в режиме записи 
		fwrite($fp, $mytext); // Запись в файл
		fclose($fp); //Закрытие файла
		
		$params = \Yii::$app->params['payment_systems']['webpay'];
		
		$batch_timestamp = Html::encode(Yii::$app->request->post('batch_timestamp', ''));
		$currency_id = Html::encode(Yii::$app->request->post('currency_id', ''));
		$amount = Html::encode(Yii::$app->request->post('amount', ''));
		$payment_method = Html::encode(Yii::$app->request->post('payment_method', ''));
		$order_id = Html::encode(Yii::$app->request->post('order_id', ''));
		$site_order_id = Html::encode(Yii::$app->request->post('site_order_id', ''));
		$transaction_id = Html::encode(Yii::$app->request->post('transaction_id', ''));
		$payment_type = Html::encode(Yii::$app->request->post('payment_type', ''));
		$rrn = Html::encode(Yii::$app->request->post('rrn', ''));
		$wsb_signature_get = Html::encode(Yii::$app->request->post('wsb_signature', ''));
		
		if($batch_timestamp != '' && $currency_id != '' && $amount != '' && $payment_method != '' && $order_id != '' && $site_order_id != '' && $transaction_id != '' && $payment_type != '' && $rrn != '') {
			$wsb_signature = md5($batch_timestamp . $currency_id . $amount . $payment_method . $order_id . $site_order_id . $transaction_id . $payment_type . $rrn . $params['SecretKey']);
			if($wsb_signature == $wsb_signature_get) {
				
				$order = Order::findOne($site_order_id);
				if ($order != null && ($payment_type == 1 || $payment_type == 4)) {
					$order->status = 4;
					$order->payment_status = 10;
					$order->pay_system = 1;
					$order->tid = $transaction_id;
					$order->payed_at = $batch_timestamp;
					$order->save();
					
					Yii::$app->mailer->compose('mail-payment-notice-manager', ['order'=>$order])
						->setTo(\Yii::$app->params['adminEmail'])
						->setFrom(\Yii::$app->params['noreplyEmail'])
						->setSubject('Оплата заказа')
						->send();
						
					Yii::$app->mailer->compose('mail-payment-notice-user', ['order'=>$order])
						->setTo($order->user->email)
						->setFrom(\Yii::$app->params['noreplyEmail'])
						->setSubject('Оплата заказа')
						->send();
					
					echo 'OK';
				}
			}
		}
		
		echo 'OK';
        return;
    }
	
	public function renderPayError($msg = 'Ошибка')
	{
		\Yii::$app->session->setFlash('error', $msg);
		return $this->render('pay-error');		
	}
}
