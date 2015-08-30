<?php
use yii\helpers\Html;
use common\helpers\DImageHelper;
?>
<div id="uploading-review-foto-list" class="uploading-tmb-list">
	<ul class="clearfix">
		<?php for ($x=0; $x<=4; $x++) { ?>
			<li class="item-<?= ($x+1) ?> pull-left <?php echo (!isset($model->review_foto[$x])) ? 'no-foto' : '' ?>" data-item="<?= ($x+1) ?>">
				<?php 
					if(isset($model->review_foto[$x]))	{
						echo Html::a(Html::img(DImageHelper::getImageUrl($model->review_foto[$x], 'reviews', 1)), DImageHelper::getImageUrl($model->review_foto[$x], 'reviews', 0), ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'examplesimages']);
						echo Html::a('×', '#', ['class' => 'remove-uploaded-file', 'data-file'=>$model->review_foto[$x]]);
						echo Html::input('hidden', 'Review[review_foto][]', $model->review_foto[$x]);
					}	else	{
						echo ($x+1);
					}	
				?>
			</li>
		<?php	}	?>
	</ul>
</div>
