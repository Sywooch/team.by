<?php

use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ActiveForm;


use frontend\assets\RegStep2Asset;
use frontend\assets\BootstrapLightboxAsset;
//use dosamigos\fileupload\FileUpload;
//use dosamigos\fileupload\FileUploadUI;

/* @var $this yii\web\View */
/* @var $model frontend\models\RegStep2Form */
/* @var $form ActiveForm */


RegStep2Asset::register($this);
BootstrapLightboxAsset::register($this);

//echo'<pre>';print_r($categories);echo'</pre>';
//echo'<pre>';print_r(Yii::$app->request->post());echo'</pre>';//die;

//$json_str = json_encode(Yii::$app->request->post()['RegStep2Form']);
//echo'<pre>';print_r(json_decode($json_str, 1));echo'</pre>';//die;
//echo'<pre>';print_r(($json_str));echo'</pre>';//die;
//echo'<pre>';print_r($model);echo'</pre>';//die;

$errors = $model->getErrors();
//echo'<pre>';print_r($errors);echo'</pre>';//die;



$categories_l2_arr = [];
?>
<div class="site-reg-step2">
		

  
  
<noscript><input type="submit" value="submit" class="button2" /></noscript>


	<div class="col-lg-8">  
	<?php $form = ActiveForm::begin([
		'options'=> ['enctype' => 'multipart/form-data' ],
		'enableClientValidation' => false,
		'id'=>'site-reg-step2-frm',
	] ); ?>

		<?= $form->field($model, 'region')->dropDownList($model->regionsDropDownList, [$model->region]) ?>
		
		<div class="form-group">
			<a href="" id="site-reg-add-new-city" class="site-reg__add-new-city">Добавить ещё один город</a>
		</div>
		
		
		
		<div id="site-reg-add-new-city-cnt" class="row clearfix site-reg-add-new-city-cnt">
			<div class="col-lg-6">
				<?= $form->field($model, 'region_parent_id')->dropDownList($model->regionsDropDownList, [$model->region]) ?>   
			</div>
			
			<div class="col-lg-6">
				<?= $form->field($model, 'region_name') ?>
			</div>
			
			<?/*
			<div class="col-lg-4">
				<a href="#" id="site-reg-add-new-city-btn" class="button-red">Добавить</a>
			</div>
			*/?>
		</div>
		
		
		<p class="about-field-descr field-descr">Опишите вашу специализацию, квалификацию, любые ваши особенности и требования. Старайтесь писать живым языком, избегая анкетных шаблонов.</p>
		<?= $form->field($model, 'about')->textarea() ?>
		
		<p class="education-field-descr field-descr">Учреждение, специальность, год окончания. Перечислите через запятую.</p>
		<?= $form->field($model, 'education')->textarea() ?>
		
		
		<?= $form->field($model, 'experience')->textarea() ?>
		
		<?= $form->field($model, 'category1')->dropDownList($model->categoriesLevel1DropDownList, [$model->category1, 'prompt'=>'Например: строительство']) ?>
		
		
		<?php foreach($categories as $cat1)	{	?>
			<div id="category-block-<?= $cat1['id']?>" class="categories-block" <?php if($model->category1 == $cat1['id']) echo 'style="display:block;"' ?> >
				<p><?php echo $cat1['name']?></p>
				<?php if(count($cat1['children']))	{	?>
						<ul class="row clearix">
						<?php
							foreach($cat1['children'] as $cat2)	{
								$categories_l2_arr[$cat2['id']] = $cat2['name'];
								echo Html::tag('li', Html::checkbox('RegStep2Form[categories][]', $model->isChecked($cat2['id']), ['label' => $cat2['name'], 'value'=>$cat2['id'], 'id'=>'category-'.$cat2['id'], 'class'=>'reg-step2-category']), ['class'=>'col-lg-4'] );	
							}	
						?>
						</ul>
					
				<?php	}	?>
			</div>				
		<?php	}	?>
		
		
		<div id="selected_categories" class="selected_categories form-horizontal solid-border-block" <?php if(count($model->price)) echo 'style="display:block;"' ?> >
			<div class="selected_categories_ttl">Выбранные рубрики</div>
			<div id="selected_categories_cnt">
				<?php foreach($model->categories as $cat) {	?>
					<div id="cnt-price-<?= $cat?>" class="form-group clearfix">
						<label for="price-<?= $cat?>" class="col-sm-5 control-label"><?= $categories_l2_arr[$cat]?></label>
						
						<div class="col-sm-6">
							<input type="text" name="RegStep2Form[price][<?= $cat?>]" class="form-control" id="price-<?= $cat?>" placeholder="Укажите стоимость" value="<?= $model->price[$cat]?>">
						</div>
						
						<div class="col-sm-1">
							<span class="site-reg-remove-price" data-category="<?= $cat?>">×</span>
						</div>
					</div>
				<?php }	?>
			</div>
		</div>
		
		
		<?//= $form->field($model, 'price_list') ?>
		
		<div id="uploading-price" class="form-group row clearfix">
			<?/*<label class="reg-step2-uploading-ttl col-lg-12"><?php echo $model->getAttributeLabel('price_list'); ?></label>*/?>
			<?= $form->field($model, 'price_list')->hiddenInput() ?>
			<div class="col-lg-4">
				<span id="upload-price-btn" class="button-red">Загрузить</span>
			</div>
			
			<div class="col-lg-5">
				<p class="uploading-info">Файл .XLS, .CSV, XLSX объёмом не более 10МБ</p>
			</div>
			
			<div class="col-lg-2">
				<img id="loading-price" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
				<span id="loading-price-success" class="reg-step2-loading-price-success">Загружено</span>
			</div>
			
			<p id="loading-price-errormes" class="reg-step2-loading-errors col-lg-12 "></p>
		</div>		
		
		<div id="uploading-awards" class="form-group clearfix">
			<label class="reg-step2-uploading-ttl"><?php echo $model->getAttributeLabel('awards'); ?></label>
			<p class="uploading-info">Отличное качество, форматы jpg, jpeg, png, gif, размер не менее 600х800px, до 5МБ</p>
			
			<div class="row clearfix">
				<div class="col-lg-4">
					<span id="upload-awards-btn" class="button-red">Загрузить</span>
				</div>
				
				<div class="col-lg-2">
					<img id="loading-awards" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
				</div>
				
				<div class="col-lg-5">
					<p id="loading-awards-errormes" class="reg-step2-loading-errors col-lg-12 "></p>
				</div>
			</div>

			<div id="uploading-awards-list" class="uploading-tmb-list">
				<ul>
					<?php for ($x=0; $x<=8; $x++) { ?>
						<li class="item-<?= ($x+1) ?> pull-left" data-item="<?= ($x+1) ?>">
							<?php 
								if(isset($model->awards[$x]))	{
									echo Html::a(Html::img(Url::home(true) . 'tmp/thumb_' .$model->awards[$x]), Url::home(true) . 'tmp/' .$model->awards[$x], ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'awardsimages']);
									echo Html::a('×', '#', ['class' => 'remove-uploaded-file', 'data-file'=>$model->awards[$x]]);
									echo Html::input('hidden', 'RegStep2Form[awards][]', $model->awards[$x]);
								}	else	{
									echo ($x+1);
								}	
							?>
						</li>
					<?php	}	?>
					<?/*				
					<li class="item-1 pull-left" data-item="1">1</li>
					<li class="item-2 pull-left" data-item="2">2</li>
					<li class="item-3 pull-left" data-item="3">3</li>
					<li class="item-4 pull-left" data-item="4">4</li>
					<li class="item-5 pull-left" data-item="5">5</li>
					<li class="item-6 pull-left" data-item="6">6</li>
					<li class="item-7 pull-left" data-item="7">7</li>
					<li class="item-8 pull-left" data-item="8">8</li>
					<li class="item-9 pull-left" data-item="9">9</li>
					*/?>
				</ul>
			</div>
		</div>		
				
		<div id="uploading-avatar" class="form-group clearfix">
			
			<div class="row clearfix">
				<div class="col-lg-7">
					<?/*<label class="reg-step2-uploading-ttl"><?php echo $model->getAttributeLabel('avatar'); ?></label> */?>
					<?= $form->field($model, 'avatar')->hiddenInput() ?>
					<p class="uploading-info">Отличное качество, форматы jpg, jpeg, png, gif, размер не менее 600х800px, до 5МБ</p>
					
					<div class="row clearfix">
						<div class="col-lg-5">
							<span id="upload-avatar-btn" class="button-red">Загрузить</span>
						</div>
						<div class="col-lg-7">
							<img id="loading-avatar" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
							<p id="loading-avatar-errormes" class="reg-step2-loading-errors"></p>
						</div>
					</div>
				</div>
				<div class="col-lg-5">
					<span id="avatar-cnt">
						<?php if($model->avatar) echo Html::a(Html::img(Url::home(true) . 'tmp/thumb_' .$model->avatar), Url::home(true) . 'tmp/' .$model->avatar, ['class' => '', 'data-toggle' => 'lightbox']) ?>
					</span>
				</div>
			</div>
		</div>
			
		<div id="uploading-examples" class="form-group clearfix">
			<div class="required <?= isset($errors['examples']) ? 'has-error' : '' ?>">
				<label class="reg-step2-uploading-ttl"><?php echo $model->getAttributeLabel('examples'); ?></label>
				
				<?= isset($errors['examples']) ? '<div class="help-block">'.$errors["examples"][0].'</div>' : '' ?>
				
			</div>
			
			
			
			<p class="reg-step2-uploading-info">Отличное качество, форматы jpg, jpeg, png, gif, размер не менее 600х800px, до 5МБ</p>
			
			<div class="row clearfix">
				<div class="col-lg-4">
					<span id="upload-examples-btn" class="button-red">Загрузить</span>
				</div>
				
				<div class="col-lg-2">
					<img id="loading-examples" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
				</div>
				
				<div class="col-lg-5">
					<p id="loading-examples-errormes" class="reg-step2-loading-errors col-lg-12 "></p>
				</div>
			</div>

			<div id="uploading-examples-list" class="uploading-tmb-list">
				<ul>
					<?php for ($x=0; $x<=8; $x++) { ?>
						<li class="item-<?= ($x+1) ?> pull-left" data-item="<?= ($x+1) ?>">
							<?php 
								if(isset($model->examples[$x]))	{
									echo Html::a(Html::img(Url::home(true) . 'tmp/thumb_' .$model->examples[$x]), Url::home(true) . 'tmp/' .$model->examples[$x], ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'examplesimages']);
									echo Html::a('×', '#', ['class' => 'remove-uploaded-file', 'data-file'=>$model->examples[$x]]);
									echo Html::input('hidden', 'RegStep2Form[examples][]', $model->examples[$x]);
								}	else	{
									echo ($x+1);
								}	
							?>
						</li>
					<?php	}	?>
					<?/*
					<li class="item-1 pull-left" data-item="1">1</li>
					<li class="item-2 pull-left" data-item="2">2</li>
					<li class="item-3 pull-left" data-item="3">3</li>
					<li class="item-4 pull-left" data-item="4">4</li>
					<li class="item-5 pull-left" data-item="5">5</li>
					<li class="item-6 pull-left" data-item="6">6</li>
					<li class="item-7 pull-left" data-item="7">7</li>
					<li class="item-8 pull-left" data-item="8">8</li>
					<li class="item-9 pull-left" data-item="9">9</li>
					*/?>
				</ul>
			</div>
		</div>		
			
			
				
		

		<div class="form-group">
			<?= Html::submitButton('Продолжить', ['class' => 'button-red']) ?>
		</div>
	<?php ActiveForm::end(); ?>
	
	</div>
	<div class="col-lg-4"></div>

</div><!-- site-reg-step2 -->
