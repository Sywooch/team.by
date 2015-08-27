<?php
// шаблон отправки письма при "Связаться с администрацией"
?>
<table>
	
	<tr>
		<td style="padding-right:20px;"><?= $model->getAttributeLabel('email1')?></td>
		<td><?= $model->email?></td>		
	</tr>
	
	<tr>
		<td><?= $model->getAttributeLabel('comment')?></td>
		<td><?= $model->comment?></td>		
	</tr>	
</table>