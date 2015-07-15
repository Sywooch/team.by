<?php
// шаблон отправки письма при заказ специалиста
?>
<table>
	
	<tr>
		<td><?= $model->getAttributeLabel('phone')?></td>
		<td><?= $model->phone?></td>		
	</tr>
	
	<tr>
		<td><?= $model->getAttributeLabel('name')?></td>
		<td><?= $model->name?></td>		
	</tr>
	
	<tr>
		<td style="padding-right:20px;"><?= $model->getAttributeLabel('email1')?></td>		
		<td><?= $model->email?></td>		
	</tr>
	
	<tr>
		<td style="vertical-align:top;"><?= $model->getAttributeLabel('comment')?></td>
		<td><?= nl2br($model->comment)?></td>		
	</tr>
</table>