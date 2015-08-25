<?php
use yii\helpers\Html;
use yii\helpers\Url;

//echo'<pre>';print_r($model->reviews);echo'</pre>';//die;

?>
<div class="tab_pane_cnt">
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Заказ</th>
				<th>Заказчик</th>
				<th>Оценка</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($model->reviews as $review)	{	?>
			<tr>
				<td><?= Html::a($review->order_id, Url::to(['order/update', 'id'=>$review->order_id]), ['target'=>'_blank']) ?></td>
				<td><?= Html::a($review->client->fio, Url::to(['client/update', 'id'=>$review->client->id]), ['target'=>'_blank']) ?></td>
				<td><?= $review->review_rating; ?></td>
				<td><a href="<?= Url::to(['review/update', 'id'=>$review->id])?>" title="Редактировать" aria-label="Редактировать" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a></td>
			</tr>
		<?php	}	?>
		</tbody>
	</table>
</div>


