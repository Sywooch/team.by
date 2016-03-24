<?php
//use yii\helpers\Url;
//use yii\helpers\Html;

?>

<div id="cnt-price-<?= $model->id ?>" class="specialization_cnt">
	<div class="specialization_cnt_ttl row clearfix">
		<div class="col-lg-9"><p class="dinpro-b">Рубрика <?= $model->name ?></p></div>
		<div class="col-lg-3 text_r"><span class="add_new_spec_btn">Добавить</span></div>
	</div>
	
	
	<ul>
		<li class="first form-group clearfix">
			<div class="col-sm-6">
				<input type="text" name="RegStep2Form[spec][]" class="form-control" placeholder="Укажите специализацию">
			</div>
			<div class="col-sm-5">
				<input type="text" name="RegStep2Form[price][]" class="form-control" placeholder="Укажите стоимость">
			</div>
			<div class="col-sm-1">
				<span class="site-reg-remove-price">×</span>
			</div>
		</li>				
	</ul>
</div>