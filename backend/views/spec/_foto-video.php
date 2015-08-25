<?php
use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ActiveForm;

//\pro\assets\DocumentsAsset::register($this);
\backend\assets\BootstrapLightboxAsset::register($this);
\pro\assets\FormStylerAsset::register($this);

?>
<div class="tab_pane_cnt">
	
		<div class="form-group uploading-tmb-list">
			<label><?php echo $model->getAttributeLabel('avatar1'); ?></label>
			<ul>
				<?php if($model->avatar)	{	?>
				<li class="avatar-foto">
					<?php echo Html::a(Html::img($model->avatarThumbUrl, ['class'=>'img-responsive']), $model->avatarUrl, ['class' => '', 'data-toggle' => 'lightbox']) ?>
					<?php echo Html::a('×', ['spec/del-file', 'id'=>$model->id, 'task'=>'avatar', 'file'=>$model->avatar], ['class' => 'remove-uploaded-file']); ?>
				</li>
				<?php	}	else	{	?>
				<li class="no-foto">1</li>
				<?php	}	?>
			</ul>
		</div>
		<br>
		<br>
		<br>
	
	<div class="form-group clearfix">
		<label><?php echo $model->getAttributeLabel('awards'); ?></label>
		<div id="uploading-awards-list" class="uploading-tmb-list">
			<ul>
				<?php for ($x=0; $x<=9; $x++) { ?>
					<li class="item-<?= ($x+1) ?> pull-left <?php echo (!isset($model->media['awards'][$x])) ? 'no-foto' : '' ?>" data-item="<?= ($x+1) ?>">
						<?php 
							if(isset($model->media['awards'][$x]))	{
								echo Html::a(Html::img(Yii::$app->params['homeUrl'] . '/' . Yii::$app->params['awards-path'] . '/thumb_' .$model->media['awards'][$x]), Yii::$app->params['homeUrl'] . '/' . Yii::$app->params['awards-path'] .'/' .$model->media['awards'][$x], ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'awardsimages']);
								echo Html::a('×', ['spec/del-file', 'id'=>$model->id, 'task'=>'awards', 'file'=>$model->media['awards'][$x]], ['class' => 'remove-uploaded-file']);
							}	else	{
								echo ($x+1);
							}	
						?>
					</li>
				<?php	}	?>
			</ul>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label><?php echo $model->getAttributeLabel('examples1'); ?></label>
		<div id="uploading-awards-list" class="uploading-tmb-list">
			<ul>
				<?php for ($x=0; $x<=9; $x++) { ?>
					<li class="item-<?= ($x+1) ?> pull-left <?php echo (!isset($model->media['examples'][$x])) ? 'no-foto' : '' ?>" data-item="<?= ($x+1) ?>">
						<?php 
							if(isset($model->media['examples'][$x]))	{
								echo Html::a(Html::img(Yii::$app->params['homeUrl'] . '/' . Yii::$app->params['examples-path'] . '/thumb_' .$model->media['examples'][$x]), Yii::$app->params['homeUrl'] . '/' . Yii::$app->params['examples-path'] .'/' .$model->media['examples'][$x], ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'awardsimages']);
								echo Html::a('×', ['spec/del-file', 'id'=>$model->id, 'task'=>'examples', 'file'=>$model->media['examples'][$x]], ['class' => 'remove-uploaded-file']);
							}	else	{
								echo ($x+1);
							}	
						?>
					</li>
				<?php	}	?>
			</ul>
		</div>
	</div>
	
	
  	<?php if($model->youtube != '')	{	?>
		<div class="form-group clearfix">
			<div class="mb-30">
				<?php echo \common\models\User::getYoutubeBlock1($model->youtube) ?>
			</div>
			<?php echo Html::a('Удалить видео', ['spec/del-file', 'id'=>$model->id, 'task'=>'youtube', 'file'=>'youtube']); ?>
		</div>
	<?php	}	?>
	
</div>