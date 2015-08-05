<?php
use frontend\helpers\DPriceHelper;
?>




<div class="tab_pane_cnt">
	<table class="table table-bordered table-striped">
		<?php foreach($model->userSpecials as $user_spec)	{	?>
			<tr>
				<td><?= $user_spec->category->name ?></td>
				<td><?= DPriceHelper::formatPrice($user_spec->price); ?></td>
			</tr>
		<?php	}	?>
	</table>
</div>