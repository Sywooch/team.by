<?php
use yii\helpers\Html;
use yii\helpers\Url;

		//echo'<pre>';print_r($model->orders);echo'</pre>';
?>

<div class="tab_pane_cnt">
<?php if(count($model->orders))	{	?>
	<ul>
	<?php foreach($model->orders as $order)	{	?>
		<li><a href="<?= Url::to(['order/update', 'id'=>$order->id])?>"><?= $order->id ?></a></li>
	<?php	}	?>
	</ul>
<?php	}	else	{	?>
	<p>Заказы отсутствуют.</p>
<?php	}	?>


</div>