<?php

namespace pro\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

use common\models\Order;
//use app\models\LoginForm;
//use app\models\ContactForm;

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
	
    public function beforeAction($action) {
        //$this->enableCsrfValidation = ($action->id !== "reg-step2-upload-price"); 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action);
    }	
	

    public function actionIndex()
    {
        //echo'<pre>';print_r($_SERVER);echo'</pre>';
		return $this->render('index');
    }

    public function actionPay($id)
    {
		// https://.../!iSOU.Login?srv_no=...&pers_acc=...& amount=...&amount_editable=...&provider_url=...		
		$order = Order::findOne($id);
		if ($order === null) {
			\Yii::$app->session->setFlash('error', 'При сохранении возникла ошибка');
			return $this->render('pay-error');
		}
		
		if ($order->payment_status == 10) {
			\Yii::$app->session->setFlash('error', 'Данный заказ уже оплачен');
			return $this->render('pay-error');
		}
		
        return $this->render('pay', [
			'order'=>$order,
			'orderNum'=>$id,
		]);
    }

    public function actionService_info()
    {
		
		
		// Константа для подписи запросов		
		$salt = addslashes('Ytrd7dhghfb787dcjd64vs7');
		
		if(isset($_POST['XML'])) {
			
			//echo'<pre>';print_r($_POST['XML']);echo'</pre>';
			$XML = $this->prerareXml($_POST['XML']);

			// Получаем подпись от iPay
			$signature = $this->getSignature();
			
			// Проверяем подпись iPay
			$this->checkSignature($XML, $salt, $signature);
			/*
			if (strcasecmp(md5($salt.$_POST['XML']), $signature)!=0)	{
				// Формируем ответ с ошибкой проверки ЦП
				$answer = '<ServiceProvider_Response><Error><ErrorLine>Ошибка проверки ЦП</ErrorLine></Error></ServiceProvider_Response>';
				$answer = mb_convert_encoding($answer, 'Windows-1251', 'UTF-8');

				// Формируем ЦП и отправляем ЦП и ответ об ошибке в iPay
				$md5 = md5($salt . $answer);
				header("ServiceProvider-Signature: SALT+MD5: $md5");
				print($answer);
				exit(0);
			}			
			/**/
			$xml = new \SimpleXMLElement($XML);
			
			$RequestType = (string) $xml->RequestType[0];
			//echo'<pre>';print_r($RequestType);echo'</pre>';
			if($RequestType == 'ServiceInfo') {
				$order_id = (string) $xml->PersonalAccount[0];
				//echo'<pre>';print_r($order_id);echo'</pre>';
				
				$order = Order::findOne($order_id);
				
				//Создает XML-строку и XML-документ при помощи DOM 
				$dom = new \DomDocument('1.0', 'windows-1251');
				
				if ($order === null) {
					//добавление корня - <ServiceProvider_Response> 
					$ServiceProvider_Response = $dom->appendChild($dom->createElement('ServiceProvider_Response')); 

					//добавление элемента <Error> в <ServiceProvider_Response> 
					$Error = $ServiceProvider_Response->appendChild($dom->createElement('Error'));
					$ErrorLine = $Error->appendChild($dom->createElement('ErrorLine'));

					// добавление элемента текстового узла <title> в <title> 
					$ErrorLine->appendChild($dom->createTextNode('Заказ номер '.$order->id.' не существует. Начните оплату заново на сайте adm.team.by')); 
				}	elseif($order->fee == 0)	{
					//добавление корня - <ServiceProvider_Response> 
					$ServiceProvider_Response = $dom->appendChild($dom->createElement('ServiceProvider_Response')); 

					//добавление элемента <Error> в <ServiceProvider_Response> 
					$Error = $ServiceProvider_Response->appendChild($dom->createElement('Error'));
					$ErrorLine = $Error->appendChild($dom->createElement('ErrorLine'));

					// добавление элемента текстового узла <title> в <title> 
					$ErrorLine->appendChild($dom->createTextNode('Сумма не задана')); 					
				}	elseif($order->payment_status == 10)	{
					$ServiceProvider_Response = $dom->appendChild($dom->createElement('ServiceProvider_Response')); 
					$Error = $ServiceProvider_Response->appendChild($dom->createElement('Error'));
					$ErrorLine = $Error->appendChild($dom->createElement('ErrorLine'));
					$ErrorLine->appendChild($dom->createTextNode('Заказ номер '.$order->id.' уже оплачен'));
					
				}	else	{
					$ServiceProvider_Response = $dom->appendChild($dom->createElement('ServiceProvider_Response')); 
					$ServiceInfo = $ServiceProvider_Response->appendChild($dom->createElement('ServiceInfo'));
					
						$Amount = $ServiceInfo->appendChild($dom->createElement('Amount'));
							$Debt = $Amount->appendChild($dom->createElement('Debt'));
								$Debt->appendChild($dom->createTextNode($order->fee));
							$Penalty = $Amount->appendChild($dom->createElement('Penalty'));
					
						$Info = $ServiceInfo->appendChild($dom->createElement('Info'));
						$InfoLine = $Info->appendChild($dom->createElement('InfoLine'));
							$InfoLine->appendChild($dom->createTextNode('Оплата комиссии за заказ N'.$order->id));
							//$InfoLine->appendChild($dom->createTextNode('Payment for order N'.$order->id));
				}
				
				//генерация xml 
				$dom->formatOutput = true; // установка атрибута formatOutput
										   // domDocument в значение true 
				// save XML as string or file 
				$response = $dom->saveXML(); // передача строки в test1 
				
				$response = $this->btw($response);	//убираем переносы строки
				
				$fp = fopen(Yii::$app->basePath."/xml.xml", "w"); // Открываем файл в режиме записи 
				
				$test = fwrite($fp, $response); // Запись в файл
				//if ($test) echo 'Данные в файл успешно занесены.';
				//else echo 'Ошибка при записи в файл.';
				fclose($fp); //Закрытие файла				
				
				$md5 = md5($salt . $response);
				
				$this->setHeaders($md5);				
				
				echo $response;
				
				die();
			}
		}
		return;
    }

    public function actionTransaction_start()
    {
		if(isset($_POST['XML'])) {
			$xml = new \SimpleXMLElement($_POST['XML']);
			$summ = (string) $xml->TransactionStart->Amount[0];
			//$error = (string) $xml->TransactionStart->ErrorLine[0];
			//echo'<pre>';var_dump($error);echo'</pre>';die;
			
			$RequestType = (string) $xml->RequestType[0];
			//echo'<pre>';print_r($RequestType);echo'</pre>';
			if($RequestType == 'TransactionStart') {
				$order_id = (string) $xml->PersonalAccount[0];
				$summ = (string) $xml->TransactionStart->Amount[0];
				
				$order = Order::findOne($order_id);
				
				$dom = new \DomDocument('1.0');
				
				if ($order === null) {
					//добавление корня - <ServiceProvider_Response> 
					$ServiceProvider_Response = $dom->appendChild($dom->createElement('ServiceProvider_Response')); 

					//добавление элемента <Error> в <ServiceProvider_Response> 
					$Error = $ServiceProvider_Response->appendChild($dom->createElement('Error'));
					$ErrorLine = $Error->appendChild($dom->createElement('ErrorLine'));

					// добавление элемента текстового узла <title> в <title> 
					$ErrorLine->appendChild($dom->createTextNode('Заказ не найден')); 
				}	elseif($order->fee == 0)	{
					
					$ServiceProvider_Response = $dom->appendChild($dom->createElement('ServiceProvider_Response')); 
						$Error = $ServiceProvider_Response->appendChild($dom->createElement('Error'));
							$ErrorLine = $Error->appendChild($dom->createElement('ErrorLine'));
								$ErrorLine->appendChild($dom->createTextNode('Сумма не задана'));
					
				}	elseif($order->fee != $summ)	{
					$ServiceProvider_Response = $dom->appendChild($dom->createElement('ServiceProvider_Response')); 
						$Error = $ServiceProvider_Response->appendChild($dom->createElement('Error'));
							$ErrorLine = $Error->appendChild($dom->createElement('ErrorLine'));
								$ErrorLine->appendChild($dom->createTextNode('Неверная сумма платежа'));					
					
				}	elseif($order->blocked == 1)	{
					$ServiceProvider_Response = $dom->appendChild($dom->createElement('ServiceProvider_Response')); 
						$Error = $ServiceProvider_Response->appendChild($dom->createElement('Error'));
							$ErrorLine = $Error->appendChild($dom->createElement('ErrorLine'));
								$ErrorLine->appendChild($dom->createTextNode('Заказ номер '.$order->id.' находится в процессе оплаты'));					
					
				}	else	{
					$TrxId = time();
					
					
					$order->blocked = 1;
					$order->tid = $TrxId;
					$order->save();
					
					$ServiceProvider_Response = $dom->appendChild($dom->createElement('ServiceProvider_Response')); 
						$TransactionStart = $ServiceProvider_Response->appendChild($dom->createElement('TransactionStart'));
							$ServiceProvider_TrxId = $TransactionStart->appendChild($dom->createElement('ServiceProvider_TrxId'));
								$ServiceProvider_TrxId->appendChild($dom->createTextNode($TrxId));
					
				}
				
				//генерация xml 
				$dom->formatOutput = true; // установка атрибута formatOutput
										   // domDocument в значение true 
				// save XML as string or file 
				$response = $dom->saveXML(); // передача строки в test1 
				echo $response;				
			}
			
		}
        return;
    }

    public function actionTransaction_result()
    {
		if(isset($_POST['XML'])) {
			$xml = new \SimpleXMLElement($_POST['XML']);
			
			$RequestType = (string) $xml->RequestType[0];
			
			if($RequestType == 'TransactionResult') {
				$order_id = (string) $xml->PersonalAccount[0];
				$summ = (string) $xml->TransactionStart->Amount[0];
				$ErrorText = (string) $xml->TransactionResult->ErrorText[0];
				$ServiceProvider_TrxId = (string) $xml->TransactionResult->ServiceProvider_TrxId[0];
				
				$order = Order::findOne($order_id);
				
				$dom = new \DomDocument('1.0');
				
				if ($order === null) {
					$ServiceProvider_Response = $dom->appendChild($dom->createElement('ServiceProvider_Response')); 

					$Error = $ServiceProvider_Response->appendChild($dom->createElement('Error'));
					$ErrorLine = $Error->appendChild($dom->createElement('ErrorLine'));

					$ErrorLine->appendChild($dom->createTextNode('Заказ не найден')); 
				}	elseif($ErrorText != '')	{
					$ServiceProvider_Response = $dom->appendChild($dom->createElement('ServiceProvider_Response')); 
						$TransactionResult = $ServiceProvider_Response->appendChild($dom->createElement('TransactionResult')); 
							$Info = $TransactionResult->appendChild($dom->createElement('Info'));
								$InfoLine = $Info->appendChild($dom->createElement('InfoLine'));
									$InfoLine->appendChild($dom->createTextNode($ErrorText));
					
					$order->blocked = 0;
					$order->tid = '';
					$order->save();
					
				}	elseif($order->tid != $ServiceProvider_TrxId)	{
					$ServiceProvider_Response = $dom->appendChild($dom->createElement('ServiceProvider_Response')); 
						$TransactionResult = $ServiceProvider_Response->appendChild($dom->createElement('TransactionResult')); 
							$Info = $TransactionResult->appendChild($dom->createElement('Info'));
								$InfoLine = $Info->appendChild($dom->createElement('InfoLine'));
									$InfoLine->appendChild($dom->createTextNode('Неверный ID транзакции'));
					
					$order->blocked = 0;
					$order->tid = '';
					$order->save();
					
				}	else	{
					
					$TransactionId = (string) $xml->TransactionResult->TransactionId[0];
					$DateTime = (string) $xml->DateTime[0];
					$year = substr($DateTime, 0, 4);
					$month = substr($DateTime, 4, 2);
					$day = substr($DateTime, 6, 2);
					$hour = substr($DateTime, 8, 2);
					$min = substr($DateTime, 10, 2);
					$sec = substr($DateTime, 12, 2);
					
					$order->tid = $TransactionId;
					$order->status = 4;
					$order->payment_status = 10;
					$order->pay_system = 2;
					$order->payed_at = mktime($hour, $min, $sec, $month, $day, $year);
					$order->blocked = 0;
					$order->save();
					
					$ServiceProvider_Response = $dom->appendChild($dom->createElement('ServiceProvider_Response')); 
						$TransactionResult = $ServiceProvider_Response->appendChild($dom->createElement('TransactionResult')); 
							$Info = $TransactionResult->appendChild($dom->createElement('Info'));
								$InfoLine = $Info->appendChild($dom->createElement('InfoLine'));
									$InfoLine->appendChild($dom->createTextNode('Заказ N' . $order->id . ' успешно оплачен.'));
					
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
				}
				
				//генерация xml 
				$dom->formatOutput = true; // установка атрибута formatOutput
										   // domDocument в значение true 
				// save XML as string or file 
				$response = $dom->saveXML(); // передача строки в test1 
				echo $response;				
			}
		}
        return;
    }
	
	function btw($b1) 
	{
        $b1 = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $b1);
        $b1 = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $b1);
        return $b1;
    }
	
	function prerareXml($xml) 
	{
		// Удаляем лишние символы до начала xml-запроса и после xml-запроса
		$xml = preg_replace('/^.*\<\?xml/sim', '<?xml', $xml);
		$xml = preg_replace('/\<\/ServiceProvider_Request\>.*/sim', '</ServiceProvider_Request>', $xml);

		// Избавляемся от экранирования
		$xml = stripslashes($_POST['XML']);
		return $xml;
    }
	
	function checkSignature($XML, $salt, $signature)
	{
		if (strcasecmp(md5($salt.$XML), $signature)!=0)	{
			// Формируем ответ с ошибкой проверки ЦП
			$answer = '<ServiceProvider_Response><Error><ErrorLine>Ошибка проверки ЦП</ErrorLine></Error></ServiceProvider_Response>';
			$answer = mb_convert_encoding($answer, 'Windows-1251', 'UTF-8');

			// Формируем ЦП и отправляем ЦП и ответ об ошибке в iPay
			$md5 = md5($salt . $answer);
			
			$this->setHeaders($md5);
			
			print($answer);
			
			die;
		}			
	}
	
	function getSignature()
	{
		$signature = '';
		if (preg_match('/SALT\+MD5\:\s(.*)/', $_SERVER['HTTP_SERVICEPROVIDER_SIGNATURE'], $matches)) {
			$signature = $matches[1];
		}
		
		return $signature;
	}
	
	function setHeaders($md5)
	{
		header('Content-Type: text/html; charset=windows-1251');
		header("ServiceProvider-Signature: SALT+MD5: $md5");
	}
}
