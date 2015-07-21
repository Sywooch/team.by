<?php
// шаблон отправки письма при "Связаться с администрацией"
?>
<table>
	
	<tr>
		<td><?= $model->getAttributeLabel('fio')?></td>
		<td><?= $model->fio?></td>		
	</tr>
	
	<tr>
		<td><?= $model->getAttributeLabel('subject1')?></td>
		<td><?= $model->subject?></td>		
	</tr>
	
	<tr>
		<td style="vertical-align:top;padding-right:50px;"><?= $model->getAttributeLabel('body1')?></td>
		<td><?= nl2br($model->body)?></td>		
	</tr>
</table>