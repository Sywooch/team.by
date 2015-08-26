<?php
use yii\helpers\Html;
// шаблон отправки письма при заказ специалиста
?>
<table>
	
	<tr>
		<td><?= $model->getAttributeLabel('phone')?></td>
		<td><?= $model->phone?></td>		
	</tr>
	
	<tr>
		<td><?= $model->getAttributeLabel('name')?></td>
		<td><?= $model->name ?></td>		
	</tr>
	
	<tr>
		<td style="padding-right:20px;"><?= $model->getAttributeLabel('email1')?></td>		
		<td><?= $model->email?></td>		
	</tr>
	
	<tr>
		<td style="padding-right:20px;">Профиль специалиста</td>		
		<td><?= Html::a($model->spec_name, 'https://adm.team.by/spec/update/'.$model->user_id)?></td>		
	</tr>
	
	<tr>
		<td style="vertical-align:top;"><?= $model->getAttributeLabel('comment')?></td>
		<td><?= nl2br($model->comment)?></td>		
	</tr>
</table>