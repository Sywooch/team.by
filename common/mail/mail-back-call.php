<?php
use yii\helpers\Html;
// шаблон отправки письма при заказе обратного звонка
?>
<table>
	
	<tr>
		<td style="padding-right:20px;"><?= $model->getAttributeLabel('phone1')?></td>
		<td><?= $model->phone?></td>		
	</tr>
	
	<tr>
		<td><?= $model->getAttributeLabel('name1')?></td>
		<td><?= $model->name ?></td>		
	</tr>
</table>