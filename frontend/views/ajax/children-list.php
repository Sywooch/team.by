<?php
//use yii\helpers\Url;
//use yii\helpers\Html;

?>


<?php if(count($children))	{	?>
	<ul id="cnt-price-<?= $model->id ?>">
	<?php	foreach($children as $child)	{	?>
		<li id="usluga-price-<?= $child->id ?>" class="form-group clearfix">
			<label for="price-<?= $child->id ?>" class="col-sm-5 control-label"><?= $child->name ?></label>
			<div class="col-sm-6">
				<input type="text" name="RegStep2Form[price][<?= $child->id ?>]" class="form-control" id="price-<?= $child->id ?>" placeholder="Укажите стоимость">
			</div>
			<div class="col-sm-1">
				<span class="site-reg-remove-price" data-category="<?= $child->id ?>">×</span>
			</div>
		</li>				
	<?php	}	?>
	</ul>	
<?php	}	?>

<?/*
<div id="cnt-price-8" class="form-group clearfix">
<label for="price-8" class="col-sm-5 control-label">электрики</label>
<div class="col-sm-6">
<input type="text" name="RegStep2Form[price][8]" class="form-control" id="price-8" placeholder="Укажите стоимость">
</div>
<div class="col-sm-1">
<span class="site-reg-remove-price" data-category="8">×</span>
</div>
</div>
*/?>