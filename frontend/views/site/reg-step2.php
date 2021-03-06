<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\RegStep2Form */
/* @var $form ActiveForm */

use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ActiveForm;

//use frontend\assets\RegAsset;
//use frontend\assets\RegStep2Asset;
///use frontend\assets\BootstrapLightboxAsset;

\frontend\assets\RegAsset::register($this);
\frontend\assets\RegStep2Asset::register($this);
\frontend\assets\BootstrapLightboxAsset::register($this);
\frontend\assets\FormStylerAsset::register($this);

$this->title = 'Информация об услугах';

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

<h1>Информация об услугах</h1>
<div class="site-reg-step2 row clearfix">
		

  
  
<noscript><input type="submit" value="submit" class="button2" /></noscript>


	<div class="col-lg-7">  
	<?php $form = ActiveForm::begin([
		'options'=> ['enctype' => 'multipart/form-data' ],
		'enableClientValidation' => false,
		'id'=>'site-reg-step2-frm',
	] ); ?>

		<?= $form->field($model, 'region')->dropDownList($model->regionsDropDownList, [$model->region]) ?>
		
		<div class="form-group">
			<a href="" id="site-reg-add-new-city" class="site-reg__add-new-city">Добавить еще один город</a>
		</div>
		
		
		
		<div id="site-reg-add-new-city-cnt" class="row clearfix site-reg-add-new-city-cnt">
			<div class="col-lg-6">
				<?= $form->field($model, 'region_parent_id')->dropDownList($model->regionsLevel1DropDownList, [$model->region_parent_id]) ?>   
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
		
		
		<p class="about-field-descr field-descr">Опишите вашу специализацию, квалификацию, любые ваши особенности и требования. Старайтесь писать живым языком, избегая анкетных шаблонов. Разрешена прямая реклама ваших услуг. Не разрешено использовать выражения, описывающие, что вы делаете какую-то работу лучше кого-то, или лучше всех. Не разрешено - оставлять свои контактные данные</p>
		<?= $form->field($model, 'about')->textarea(['rows'=>5]) ?>
		
		<p class="education-field-descr field-descr">Учреждение, специальность, год окончания. Перечислите через запятую.</p>
		<?= $form->field($model, 'education')->textarea(['rows'=>5]) ?>
		
		
		<?= $form->field($model, 'experience')->textarea(['rows'=>5]) ?>
		
		<?= $form->field($model, 'to_client')->checkbox() ?>
		
		<?= $form->field($model, 'specialization') ?>
		
		
		<?= $this->render('@app/views/profile/_categories-block', ['form'=>$form, 'model'=>$model, 'categories'=>$categories, 'categories_l3'=>$categories_l3, 'model_name'=>'RegStep2Form' ])?>
				
		<div id="uploading-price" class="form-group row clearfix">
			<?/*<label class="reg-step2-uploading-ttl col-lg-12"><?php echo $model->getAttributeLabel('price_list'); ?></label>*/?>
			<div class="col-lg-12">
				<?= $form->field($model, 'price_list')->hiddenInput() ?>
			</div>

			<div class="col-lg-4">
				<span id="upload-price-btn" class="button-red">Загрузить</span>
			</div>
			
			<div class="col-lg-2">
				<img id="loading-price" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
				<span id="loading-price-success" class="reg-step2-loading-price-success">Загружено</span>
			</div>			
			
			<div class="col-lg-5">
				<p class="uploading-info">Файл .XLS, .CSV, XLSX объемом не более 10МБ</p>
			</div>
			
			<p id="loading-price-errormes" class="reg-step2-loading-errors col-lg-12"></p>
		</div>		
		
		<div id="uploading-awards" class="form-group clearfix">
			<label class="reg-step2-uploading-ttl"><?php echo $model->getAttributeLabel('awards'); ?></label>
			<p class="uploading-info">Отличное качество, форматы jpg, jpeg, png, gif, размер не менее 600х800px, до 5МБ</p>
			
			<div class="row clearfix">
				<div class="col-lg-4">
					<span id="upload-awards-btn" class="button-red">Загрузить</span>
				</div>
				
				<div class="col-lg-1">
					<img id="loading-awards" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
				</div>
				
				<div class="col-lg-6">
					<p id="loading-awards-errormes" class="reg-step2-loading-errors col-lg-12 "></p>
				</div>
			</div>

			<div id="uploading-awards-list" class="uploading-tmb-list">
				<ul>
					<?php for ($x=0; $x<=9; $x++) { ?>
						<li class="item-<?= ($x+1) ?> pull-left <?php echo (!isset($model->awards[$x])) ? 'no-foto' : '' ?>" data-item="<?= ($x+1) ?>">
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
						<div class="col-lg-6">
							<span id="upload-avatar-btn" class="button-red">Загрузить</span>
						</div>
						<div class="col-lg-6">
							<img id="loading-avatar" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
						</div>
						<div class="col-lg-12">
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
				
				<div class="col-lg-1">
					<img id="loading-examples" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
				</div>
				
				<div class="col-lg-6">
					<p id="loading-examples-errormes" class="reg-step2-loading-errors"></p>
				</div>
			</div>

			<div id="uploading-examples-list" class="uploading-tmb-list">
				<ul>
					<?php for ($x=0; $x<=9; $x++) { ?>
						<li class="item-<?= ($x+1) ?> pull-left <?php echo (!isset($model->examples[$x])) ? 'no-foto' : '' ?>" data-item="<?= ($x+1) ?>">
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
				</ul>
			</div>
		</div>		
			
		<div id="uploading-license" class="form-group clearfix">
			<div class="row clearfix">
				<div class="col-lg-7">
					<?= $form->field($model, 'license')->hiddenInput() ?>
					<p class="uploading-info">Отличное качество, форматы jpg, jpeg, png, gif, размер не менее 600х800px, до 5МБ</p>
					
					<div class="row clearfix">
						<div class="col-lg-6">
							<span id="upload-license-btn" class="button-red">Загрузить</span>
						</div>
						<div class="col-lg-6">
							<img id="loading-license" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
						</div>
						<div class="col-lg-12">
							<p id="loading-license-errormes" class="reg-step2-loading-errors"></p>
						</div>
					</div>
				</div>
				<div class="col-lg-5">
					<span id="license-cnt">
						<?php if($model->license) echo Html::a(Html::img(Url::home(true) . 'tmp/thumb_' .$model->license), Url::home(true) . 'tmp/' .$model->license, ['class' => '', 'data-toggle' => 'lightbox']) ?>
					</span>
				</div>
			</div>
		</div>
			
				
		

		<div class="form-group">
			<?= Html::submitButton('Продолжить', ['class' => 'button-red']) ?>
		</div>
	<?php ActiveForm::end(); ?>
	
	</div>
	
	<div class="col-lg-4 col-lg-offset-1">
		<div class="reg_info">
			<div class="reg_info_ttl">
				Преимущества для специалистов team.by
			</div>
			<div class="reg_info_cnt">
				<p>
					<span>Работать с нами удобно!</span>
					<br><br>
					Оплатить наши услуги можно в любом интернет банке, мобильном банке, банкомате, инфокиоске, в кассе любого банка Республики Беларусь через систему ЕРИ.П
				</p>
			</div>
		</div>
	</div>


</div><!-- site-reg-step2 -->
