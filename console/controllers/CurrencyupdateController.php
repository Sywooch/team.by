<?php
 
namespace console\controllers;
 
use yii\console\Controller;
use common\models\Currency;
 
/**
 * Test controller
 */
class CurrencyupdateController extends Controller {
 
    public function actionIndex() {
		$xml = simplexml_load_file('http://www.nbrb.by/Services/XmlExRates.aspx?ondate='.\Yii::$app->formatter->asDate(time(), 'php:m/d/yy'));
		
		echo "currency rate update ".\Yii::$app->formatter->asDate(time(), 'php:m/d/yy');
																   
		foreach($xml->Currency as $currency) {
			foreach($currency->attributes() as $a => $b) {
				if($a == 'Id' && $b == 145) {
					//echo $a,'="',$b,"\"\n";
					$rate = $currency->Rate;
					$code = $currency->NumCode;
					//echo $code . ' | ' . $rate . "\"\n";
					break;	
				}
				
			}
			
			
		}
		
		$model = Currency::findOne(['num_code' => $code]);
		if($model !== NULL) {
			$model->rate = $rate;
			$model->save();
		}	else	{
			echo ' Запись не найдена';
		}
		
		/*
		$filename = '/home/team/domains/team.by/team/frontend/web/cron.log';
		$mytext = Yii::$app->formatter->asDate(time(), 'php:d-m-yy G:i:s'). ' - cron service runnning';	

		$fp = fopen($filename, "w"); // Открываем файл в режиме записи 
		//$mytext = time().$xml->RequestType;
		//$mytext = Yii::$app->formatter->asDate(time(), 'php:d-m-yy G:i:s').$_POST['XML'];
		fwrite($fp, $mytext); // Запись в файл
		//if ($test) echo 'Данные в файл успешно занесены.';
		//else echo 'Ошибка при записи в файл.';
		fclose($fp); //Закрытие файла
		*/
    }
 
    public function actionMail($to) {
        echo "Sending mail to " . $to;
    }
 
}
// /usr/local/bin/php /home/team/domains/team.by/team/yii currencyupdate
?>