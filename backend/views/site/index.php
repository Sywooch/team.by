<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
//use dosamigos\datepicker\DatePicker;


$this->title = 'АдминПанель';

// забирает текущее время в массив
$timestamp = time();
//echo'<pre>';print_r($timestamp);echo'</pre>';//die;

$date_time_array = getdate($timestamp);
//echo'<pre>';print_r($date_time_array);echo'</pre>';//die;
//echo'<pre>';print_r(Yii::$app->formatter->asDate($timestamp, 'php:d-m-yy'));echo'</pre>';//die;


$hours = $date_time_array['hours'];
$minutes = $date_time_array['minutes'];
$seconds = $date_time_array['seconds'];
$month = $date_time_array['mon'];
$day = $date_time_array['mday'];
$year = $date_time_array['year'];

// используйте mktime для обновления UNIX времени
/*
$timestamp = mktime($hours,$minutes,$seconds,$month,($day - 55),$year);
$date_time_array = getdate($timestamp);
echo'<pre>';print_r($timestamp);echo'</pre>';//die;

echo'<pre>';print_r($date_time_array);echo'</pre>';//die;
echo'<pre>';print_r(Yii::$app->formatter->asDate($timestamp, 'php:d F'));echo'</pre>';//die;
*/
$start_day = $day - 6;
$end_day = $day + 6;




?>
<div class="site-index">

    <div class="jumbotron">
        <h1>АдминПанель</h1>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-6">
                <h2>Заказы</h2>
					<div class="row">
					<?php
						$i = 1;
						for ($day=$start_day; $day<=$end_day; $day++)	{
							$timestamp = mktime(0, 0, 0, $month, $day, $year);
							//echo'<pre>';print_r(Yii::$app->formatter->asDate($timestamp, 'php:d F'));echo'</pre>';//die;
							if($day != $date_time_array['mday']) {
								$button_class = 'btn btn-default';
							}	else	{
								$button_class = 'btn btn-info';
							}
							
							echo Html::tag('div', Html::a(Yii::$app->formatter->asDate($timestamp, 'php:d F'), ['sheduler/orders', 'date' => Yii::$app->formatter->asDate($timestamp, 'php:d-m-yy')], ['class'=>$button_class]), ['class' => 'col-lg-4 calendar-list-item'] );
						}
					?>
                	</div>

            </div>
            <div class="col-lg-6">
                <h2>Специалисты</h2>
                
                <p><a class="btn btn-default" href="<?= Url::to(['spec/index', 'UserSearch[user_status]'=>0])?>">Новые специалисты</a></p>
                <p><a class="btn btn-default" href="<?= Url::to(['spec/index', 'UserSearch[user_status]'=>2])?>">Требуют проверки</a></p>
                <p><a class="btn btn-default" href="<?= Url::to(['toadministration/index'])?>">Новые сообщения (<?= count($unreadMessages) ?>)</a></p>

            </div>
        </div>

    </div>
</div>
