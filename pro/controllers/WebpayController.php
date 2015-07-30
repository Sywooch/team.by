<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use yii\helpers\Html;

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

    public function actionPay($id)
    {
		$order = \app\models\Order::findOne($id);
		if ($order === null) {
			\Yii::$app->session->setFlash('error', 'При сохранении возникла ошибка');
			return $this->render('pay-error');
		}
		
        return $this->render('pay', ['order'=>$order]);
    }

    public function actionComplete()
    {
		//wsb_order_num=3&wsb_tid=219501653
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
		echo $response;
		
		$xml = new \SimpleXMLElement($response);
		
		$status = (string) $xml->status[0];
		
		if($status == 'failed') {
			\Yii::$app->session->setFlash('error', 'Ошибка обработки платежа');
			return $this->render('pay-error');			
		}
		//<status>failed</status>
			//<status>success</status>
		
		//echo'<pre>';print_r($status);echo'</pre>';
		//echo'<pre>';print_r($xml);echo'</pre>';

		
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
		
		//echo'<pre>';print_r($wsb_signature_get);echo'</pre>';
		//echo'<pre>';print_r($wsb_signature);echo'</pre>';
		
		
		
		$order = \app\models\Order::findOne($wsb_order_num);
		if ($order === null) {
			\Yii::$app->session->setFlash('error', 'Заказ не существует');
			return $this->render('pay-error');
		}
		if($order->payment_status != 10) {
			$order->payment_status = 10;
			$order->pay_system = 1;
			$order->tid = $wsb_tid;
			$order->payed_at = time();
			$order->save();			
		}
		
		//echo'<pre>';print_r($wsb_order_num);echo'</pre>';
		//echo'<pre>';print_r($wsb_tid);echo'</pre>';
		
		\Yii::$app->session->setFlash('success', 'Заказ успешно оплачен');
		
        return $this->render('complete', ['order'=>$order]);
    }

    public function actionCancel()
    {
		
        return $this->render('cancel');
    }

    public function actionNotify()
    {
		
        return $this->render('notify');
    }

}
