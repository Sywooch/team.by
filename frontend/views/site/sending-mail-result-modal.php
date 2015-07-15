<?php
use frontend\widgets\Alert;
use yii\helpers\Html;
?>


<div class="modal-dialog modal-dialog__zakaz-spec1 modal-content">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h2 class="h2__modal"><?= Html::encode($title) ?></h2>
		</div>
		
		<div class="modal-body">
			<?= Alert::widget() ?>		
		</div>
	</div>
</div>

