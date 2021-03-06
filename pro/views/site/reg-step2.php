<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\RegStep2Form */
/* @var $form ActiveForm */

use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ActiveForm;

use common\helpers\DImageHelper;

//use frontend\assets\RegAsset;
//use frontend\assets\RegStep2Asset;
///use frontend\assets\BootstrapLightboxAsset;

\frontend\assets\RegAsset::register($this);
\frontend\assets\RegStep2Asset::register($this);
\frontend\assets\BootstrapLightboxAsset::register($this);
\frontend\assets\FormStylerAsset::register($this);

$this->title = \Yii::$app->params['sitename'] .' | ' . 'Информация об услугах';

//echo'<pre>';print_r($categories);echo'</pre>';
//echo'<pre>';print_r(Yii::$app->request->post());echo'</pre>';//die;

//$json_str = json_encode(Yii::$app->request->post()['RegStep2Form']);
//echo'<pre>';print_r(json_decode($json_str, 1));echo'</pre>';//die;
//echo'<pre>';print_r(($json_str));echo'</pre>';//die;
//echo'<pre>';print_r($model);echo'</pre>';//die;

$errors = $model->getErrors();
//echo'<pre>';print_r($model->regions);echo'</pre>';//die;



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
		
		<?php echo $form->errorSummary($model); ?>
		
		<input type="hidden" id="form_name" value="RegStep2Form">
		
		<?php echo $this->render('@pro/views/profile/_add-regions-frm', ['form_name'=>'RegStep2Form', 'model'=>$model], false, true); ?>
		
		<p class="about-field-descr field-descr">Опишите вашу специализацию, квалификацию, любые ваши особенности и требования. Старайтесь писать живым языком, избегая анкетных шаблонов. Разрешена прямая реклама ваших услуг. Не разрешено использовать выражения, описывающие, что вы делаете какую-то работу лучше кого-то, или лучше всех. Не разрешено - оставлять свои контактные данные</p>
		<?= $form->field($model, 'about')->textarea(['rows'=>5]) ?>
		
		<p class="education-field-descr field-descr">Учреждение, специальность, год окончания. Перечислите через запятую.</p>
		<?= $form->field($model, 'education')->textarea(['rows'=>5]) ?>
		
		
		<?= $form->field($model, 'experience')->textarea(['rows'=>5]) ?>
		
		<?= $form->field($model, 'to_client')->checkbox() ?>
		
		<p class="specialization-field-descr field-descr">Опишите тот вид работы, который вам удается особенно хорошо. Например - "могу подготовить к экзамену по физике твердого тела за три дня" или "отлично разбираюсь в гидравлической системе ситроен ксантиа."</p>
		<?= $form->field($model, 'specialization') ?>
		
		
		<?= $this->render('@app/views/profile/_categories-block', ['form'=>$form, 'model'=>$model, 'categories'=>$categories, 'categories_l3'=>$categories_l3, 'model_name'=>'RegStep2Form', 'show_all'=>true ])?>
		
		<?/*<div class="form-group"><span class="dinpro-b pr-20">Чего-то не хватает?</span> <span id="offer-service" class="button-blue button-narrow" data-url="<?= Yii::$app->params['homeUrl'].Url::to(['site/offer-service'])?>">Предложить услугу</span></div>*/?>
		<div class="form-group"><span class="dinpro-b pr-20">Чего-то не хватает?</span> <a class="button-blue button-narrow" href="<?= Yii::$app->params['homeUrl'].Url::to(['site/offer-service'])?>" target="_blank">Предложить услугу</a></div>
				
		<div id="uploading-price" class="form-group row clearfix">
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
			<p class="uploading-info">Если вам есть чем гордиться - обязательно покажите это.<br>Отличное качество, форматы jpg, jpeg, png, gif, размер не менее 1024х768px, до 5МБ</p>
			
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
									echo Html::a(Html::img(DImageHelper::getImageUrl($model->awards[$x], 'tmp', 1, 1)), DImageHelper::getImageUrl($model->awards[$x], 'tmp', 0, 1), ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'awardsimages']);
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
					<p class="uploading-info">Отличное качество, форматы jpg, jpeg, png, gif, размер не менее 1024х768px, до 5МБ</p>
					
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
						<?php if($model->avatar) echo Html::a(Html::img(DImageHelper::getImageUrl($model->avatar, 'tmp', 1, 1)), DImageHelper::getImageUrl($model->avatar, 'tmp', 0, 1), ['class' => '', 'data-toggle' => 'lightbox']); ?>
					</span>
				</div>
			</div>
		</div>
			
		<div id="uploading-examples" class="form-group clearfix">
			<div class=" <?= isset($errors['examples']) ? 'has-error' : '' ?>">
				<label class="reg-step2-uploading-ttl"><?php echo $model->getAttributeLabel('examples'); ?></label>
				
				<?= isset($errors['examples']) ? '<div class="help-block">'.$errors["examples"][0].'</div>' : '' ?>
				
			</div>
			
			<p class="uploading-info">Отличное качество, форматы jpg, jpeg, png, gif, размер не менее 1024х768px, до 5МБ</p>
			
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
									//echo Html::a(Html::img('http://team.by/tmp/thumb_' .$model->examples[$x]), 'http://team.by/tmp/' .$model->examples[$x], ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'examplesimages']);
									echo Html::a(Html::img(DImageHelper::getImageUrl($model->examples[$x], 'tmp', 1, 1)), DImageHelper::getImageUrl($model->examples[$x], 'tmp', 0, 1), ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'examplesimages']);
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
			
		<div class="ros-rel mb-30">
			<p class="youtube-field-descr field-descr">Иногда проще один раз показать, чем сто раз написать. Здесь вы можете оставить ссылку на ваше видеообращение.</p>
			<?= $form->field($model, 'youtube') ?>			
			<div>
				<?php if($model->youtube != '') echo \common\models\User::getYoutubeBlock1($model->youtube)?>	
			</div>
		</div>

		<input type="hidden" name="aad" value="12323123123">

		<div class="form-group pt-30">
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
					Оплатить наши услуги можно в любом интернет банке, мобильном банке, банкомате, инфокиоске, в кассе любого банка Республики Беларусь через систему ЕРИП.
					<br><br>
					Также вы можете оплатить наши услуги при помощи карточек Visa, Mastercard или Белкарт в своем личном кабинете.
				</p>
				
			</div>
		</div>
	</div>


</div><!-- site-reg-step2 -->
