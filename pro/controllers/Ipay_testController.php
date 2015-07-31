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
		$order = \app\models\Order::findOne($id);
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
		
		$salt = addslashes('2134234fasdasd');
		/*
	*/
		if(isset($_POST['XML'])) {
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
			
			$xml = new \SimpleXMLElement($_POST['XML']);
			
			$RequestType = (string) $xml->RequestType[0];
			//echo'<pre>';print_r($RequestType);echo'</pre>';
			if($RequestType == 'ServiceInfo') {
				$order_id = (string) $xml->PersonalAccount[0];
				//echo'<pre>';print_r($order_id);echo'</pre>';
				
				$order = \app\models\Order::findOne($order_id);
				
				//Создает XML-строку и XML-документ при помощи DOM 
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
					//добавление корня - <ServiceProvider_Response> 
					$ServiceProvider_Response = $dom->appendChild($dom->createElement('ServiceProvider_Response')); 

					//добавление элемента <Error> в <ServiceProvider_Response> 
					$Error = $ServiceProvider_Response->appendChild($dom->createElement('Error'));
					$ErrorLine = $Error->appendChild($dom->createElement('ErrorLine'));

					// добавление элемента текстового узла <title> в <title> 
					$ErrorLine->appendChild($dom->createTextNode('Сумма не задана')); 					
				}	else	{
					$ServiceProvider_Response = $dom->appendChild($dom->createElement('ServiceProvider_Response')); 
					$ServiceInfo = $ServiceProvider_Response->appendChild($dom->createElement('ServiceInfo'));
					
						$Amount = $ServiceInfo->appendChild($dom->createElement('Amount'));
							$Debt = $Amount->appendChild($dom->createElement('Debt'));
								$Debt->appendChild($dom->createTextNode($order->fee));
							$Penalty = $Amount->appendChild($dom->createElement('Penalty'));
					
						$Info = $ServiceInfo->appendChild($dom->createElement('Info'));
						$InfoLine = $Info->appendChild($dom->createElement('InfoLine'));
							$InfoLine->appendChild($dom->createTextNode('Оплата комисси за заказ N'.$order->id));
/*
<?xml version="1.0" encoding="windows-1251" ?>
<ServiceProvider_Response>
	<ServiceInfo>
		<Amount Editable="N" MinAmount="1000" MaxAmount="100000" AmountPrecision="50">
			<Debt>9200000</Debt>
			<Penalty/>
		</Amount>
		<Info xml:space="preserve">
			<InfoLine>Заказ "123", оформленный на сайте tv.by.</InfoLine>
			<InfoLine>Телевизор Sumsung 48EU6500. </InfoLine>
			<InfoLine>Сумма: 9 200 000 бел. руб.</InfoLine>
		</Info>
	</ServiceInfo>
</ServiceProvider_Response>
*/
				}
				
				//генерация xml 
				$dom->formatOutput = true; // установка атрибута formatOutput
										   // domDocument в значение true 
				// save XML as string or file 
				$response = $dom->saveXML(); // передача строки в test1 
				echo $response;
			}
		}
		//echo '1111';
		//exit();
		return;


		
		
        //return $this->render('service-info');
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
				
				$order = \app\models\Order::findOne($order_id);
				
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
					
				}	else	{
					/*
<ServiceProvider_Response>
	<TransactionStart>
		<ServiceProvider_TrxId>8571502</ServiceProvider_TrxId>
	</TransactionStart>
</ServiceProvider_Response>					
*/					$TrxId = time();
					//echo'<pre>';var_dump($ServiceProvider_TrxId);echo'</pre>';die;
					
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
        //return $this->render('transaction-start');
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
				
				
				$order = \app\models\Order::findOne($order_id);
				
				$dom = new \DomDocument('1.0');
				
				
				
				if ($order === null) {
					$ServiceProvider_Response = $dom->appendChild($dom->createElement('ServiceProvider_Response')); 

					$Error = $ServiceProvider_Response->appendChild($dom->createElement('Error'));
					$ErrorLine = $Error->appendChild($dom->createElement('ErrorLine'));

					$ErrorLine->appendChild($dom->createTextNode('Заказ не найден')); 
				}	elseif($ErrorText != '')	{
/*
<ServiceProvider_Response>
	<TransactionResult>
		<Info xml:space="preserve">
			<InfoLine>Операция отменена</InfoLine>
		</Info>
	</TransactionResult>
</ServiceProvider_Response>

*/
					$ServiceProvider_Response = $dom->appendChild($dom->createElement('ServiceProvider_Response')); 
						$TransactionResult = $ServiceProvider_Response->appendChild($dom->createElement('TransactionResult')); 
							$Info = $TransactionResult->appendChild($dom->createElement('Info'));
								$InfoLine = $Info->appendChild($dom->createElement('InfoLine'));
									$InfoLine->appendChild($dom->createTextNode($ErrorText));					
					
				}	elseif($order->tid != $ServiceProvider_TrxId)	{
					
					$ServiceProvider_Response = $dom->appendChild($dom->createElement('ServiceProvider_Response')); 
						$TransactionResult = $ServiceProvider_Response->appendChild($dom->createElement('TransactionResult')); 
							$Info = $TransactionResult->appendChild($dom->createElement('Info'));
								$InfoLine = $Info->appendChild($dom->createElement('InfoLine'));
									$InfoLine->appendChild($dom->createTextNode('Неверный ID транзакции'));
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
					$order->payment_status = 10;
					$order->pay_system = 2;
					$order->payed_at = mktime($hour, $min, $sec, $month, $day, $year);
					$order->save();
					
					$ServiceProvider_Response = $dom->appendChild($dom->createElement('ServiceProvider_Response')); 
						$TransactionResult = $ServiceProvider_Response->appendChild($dom->createElement('TransactionResult')); 
							$Info = $TransactionResult->appendChild($dom->createElement('Info'));
								$InfoLine = $Info->appendChild($dom->createElement('InfoLine'));
									$InfoLine->appendChild($dom->createTextNode('Заказ N' . $order->id . ' успешно оплачен.'));
					
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
		
        //return $this->render('transaction-result');
    }
}
