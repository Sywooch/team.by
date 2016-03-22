<?php
use yii\helpers\Html;
use yii\helpers\Url;

if(count($model->regions)) {
	$regions_rows = count($model->regions) - 1;
}	else	{
	$regions_rows = 0;
}

//var_dump($model->regions);die;
?>
<div id="regions-wr">
	<div id="regions-cnt" class="regions-cnt">
		<label class="control-label regions-label"><?php echo $model->getAttributeLabel('region'); ?></label>
		<?php for ($x=0; $x<=$regions_rows; $x++) { ?>
			<div <?php if ($x==0) echo 'id="region-row-f"' ?> class="form-group row clearfix region-row">
				<div class="col-lg-8 region-dd-cnt">
					<?= Html::dropDownList($form_name.'[regions][]', isset($model->regions[$x]) ? $model->regions[$x] : '0', $model->regionsDropDownList, ['class'=>'form-control']) ?>
				</div>
				<div class="col-lg-3">
					<?= Html::textInput($form_name.'[ratios][]', isset($model->ratios[$x]) ? $model->ratios[$x] : '0', ['placeholder'=>'коэффициент', 'class'=>'form-control']) ?>
				</div>
				<div class="col-lg-1">
					<a href="#" class="remove_region_row">—</a>
				</div>
			</div>
			
			<?php if ($x==0) { ?>
				<p id="regions-field-descr" class="regions-field-descr field-descr" <? if(($regions_rows+1) == 1) echo 'style="display:none;"'?>>Если вы оказываете услуги в разных городах, для некоторых из них можно установить повышающий коэффициент на работу. Ваши клиенты из этих городов будут видеть более высокие цены. Например, ваш основной город Минск, а в Заславле вы согласны работать, если вам заплатят на 20% больше, тогда напротив Заславля выставляете коэффициент 1.2.</p>
			<?php	}	?>
			
		<?php	}	?>
	</div>

	<div class="form-group">
		<a href="#" class="add_new_region">Добавить еще регион</a>
		<img id="adding-region" class="adding-region" src="/images/loading.gif" alt="Loading" />
	</div>
</div>
