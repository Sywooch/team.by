<?php
 
namespace console\controllers;

//use Yii;
use yii\console\Controller;
use common\models\Currency;
use common\models\User;
use common\models\Order;
use common\models\Notify;
 
/**
 * Test controller
 */
class CronController extends Controller {
//class CurrencyupdateController extends Controller {
 
    public function actionCurrencyUpdate() {
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
	
	public function actionCheckActualLicense() {
		$timestamp = time();

		$date_time_array = getdate($timestamp);
		//echo'<pre>';print_r($date_time_array);echo'</pre>';//die;

		$hours = $date_time_array['hours'];
		$minutes = $date_time_array['minutes'];
		$seconds = $date_time_array['seconds'];
		$month = $date_time_array['mon'];
		$day = $date_time_array['mday'];
		$year = $date_time_array['year'];

		// используйте mktime для обновления UNIX времени
		$start_day = $day + 30;

		$timestamp = mktime(0, 0, 0, $month, $start_day, $year);
		
		$rows = User::find()
			->where(['<>', 'license_checked', ''])
			->andWhere(['=', 'license_checked', $timestamp])
			->all();
		echo count($rows);
		echo $timestamp;
		foreach($rows as $model) {
			
			$notify = new Notify();
			$notify->user_id = $model->id;
			$notify->msg = \Yii::$app->formatter->asDate(time(), 'php:d-m-yy'). ' заканчивается срок действия лицензии. Необходимо предоставить актуальный документ';
			$notify->save();
			
			\Yii::$app->mailer->compose('mail-notify-actual-license', ['model'=>$model])
				->setTo($model->email)
				->setFrom(\Yii::$app->params['noreplyEmail'])
				->setSubject('Заканчивается срок действия лицензии')
				->send();
		}
	}
 
	//проверяем сроки оплаты заказов чтобы перевести статус оплаты в "просрочена"
	public function actionCheckPayments() {
		$timestamp = time();

		$date_time_array = getdate($timestamp);
		//echo'<pre>';print_r($date_time_array);echo'</pre>';//die;

		$hours = $date_time_array['hours'];
		$minutes = $date_time_array['minutes'];
		$seconds = $date_time_array['seconds'];
		$month = $date_time_array['mon'];
		$day = $date_time_array['mday'];
		$year = $date_time_array['year'];

		// используйте mktime для обновления UNIX времени
		//$start_day = $day + 30;

		$timestamp = mktime(0, 0, 0, $month, $day, $year);
		
		$rows = Order::find()
			->where(['<', 'payment_date', $timestamp])
			->andWhere(['<>', 'user_id', -1])
			->all();
		
		//echo count($rows);
		//echo $timestamp;
		foreach($rows as $model) {
			if($model->payment_date != '') {
				$model->payment_status = 2;
				$model->save();
				
				$notify = new Notify();
				$notify->user_id = $model->user_id;
				//$notify->msg = \Yii::$app->formatter->asDate(time(), 'php:d-m-yy'). ' заканчивается срок действия лицензии. Необходимо предоставить актуальный документ';
				$notify->msg = 'Вы не оплатили комиссию на заказ №'.$model->id.', во избежании блокировки аккаунта, оплатите комиссию.';
				$notify->save();

				\Yii::$app->mailer->compose('mail-notify-payment', ['model'=>$model])
					//->setTo($model->user->email)
					->setTo('aldegtyarev@yandex.ru')
					->setFrom(\Yii::$app->params['noreplyEmail'])
					->setSubject('Вы не оплатили комиссию на заказ №'.$model->id)
					->send();
			}
		}
	}
 
    //чистка временной папки от загруженных туда файлов
	public function actionClearTmpImages() {
		$path = \Yii::getAlias('@frontend') . '/web/tmp'; // Путь до папки
		$time = time() - 1 * 86400; // Отсчитываем 1 день

		$dir = scandir($path); // Получаем список папок и файлов
		
		foreach($dir as $name) {
			if($name == '.' || $name == '..') continue;

			if(is_file($path.'/'.$name) == TRUE) { // проверяем, действительно ли это файл
				$ftime = filemtime($path.'/'.$name); // получаем последнее время модификации файла
				if($ftime < $time) {
					unlink($path.'/'.$name); // удаляем файл
				}
			}
		}
		
		$dir = scandir($path); // Получаем список папок и файлов
		//echo'<pre>';print_r(count($dir));echo'</pre>';//die;
		echo 'actionClearTmpImages';
    }
 
    public function actionMail($to) {
        echo "Sending mail to " . $to;
    }
 
}
// /usr/local/bin/php /home/team/domains/team.by/team/yii currencyupdate
?>