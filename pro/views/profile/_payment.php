<?php

use yii\helpers\Html;

?>
<div class="profile-payment-type">
	<?php if($model !== null)	{	?>
		<div class="page-body">
			<?= \common\helpers\DImageHelper::processImagesToHttps($model->text) ?>
		</div>
	<?php	}	?>
</div>
