<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\ProfileAnketaForm  */
/* @var $form ActiveForm */

use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ActiveForm;

use common\helpers\DImageHelper;
use common\helpers\DYoutubeHelper;

\pro\assets\RegAsset::register($this);
\pro\assets\RegStep2Asset::register($this);
\frontend\assets\BootstrapLightboxAsset::register($this);
\pro\assets\FormStylerAsset::register($this);


//echo'<pre>';print_r($categories);echo'</pre>';
//echo'<pre>';print_r(Yii::$app->request->post());echo'</pre>';//die;

//$json_str = json_encode(Yii::$app->request->post()['ProfileAnketaForm ']);
//echo'<pre>';print_r(json_decode($json_str, 1));echo'</pre>';//die;
//echo'<pre>';print_r(($json_str));echo'</pre>';//die;
//echo'<pre>';print_r($model);echo'</pre>';//die;

$errors = $model->getErrors();
//echo'<pre>';print_r($errors);echo'</pre>';//die;


$categories_l2_arr = [];

?>
<div class="profile_anketa row1 clearfix1">
 
 <p class="h1">Личные данные</p>
  
	<noscript><input type="submit" value="submit" class="button2" /></noscript>


		<?php $form = ActiveForm::begin([
			'options'=> ['enctype' => 'multipart/form-data' ],
			'enableClientValidation' => false,
			'id'=>'anketa-frm',
		] ); ?>
		
		<?php echo $form->errorSummary($model); ?>
		
		<input type="hidden" id="form_name" value="ProfileAnketaForm">
		
		<div class="profile_anketa_row">
			<div class="row clearfix"> 
				<div class="col-lg-6"><?= $form->field($model, 'fio')->textInput(['readonly'=>'readonly']) ?></div>
				<div class="col-lg-6"><?= $form->field($model, 'email')->textInput(['readonly'=>'readonly']) ?></div>
				<div class="col-lg-6"><?= $form->field($model, 'phone')->textInput(['readonly'=>'readonly']) ?></div>
			</div>
		</div>
		
		<div class="profile_anketa_row">
			<div class="row clearfix">
				<div class="col-lg-6"><?= $form->field($model, 'passwordNew')->passwordInput() ?></div>
				<div class="col-lg-6"><?= $form->field($model, 'passwordRepeat')->passwordInput() ?></div>
			</div>
		</div>
		
		<div class="profile_anketa_row pos-rel">
			<p class="h1">Информация об услугах</p>
		
			<div class="row clearfix">
				<div class="col-lg-12">
					<?php echo $this->render('@pro/views/profile/_add-regions-frm', ['form_name'=>'ProfileAnketaForm', 'model'=>$model], false, true); ?>
				</div>
				
				<div class="col-lg-6"></div>
				
				<div class="col-lg-12">
					<p class="about-field-descr field-descr">Опишите вашу специализацию, квалификацию, любые ваши особенности и требования. Старайтесь писать живым языком, избегая анкетных шаблонов. Разрешена прямая реклама ваших услуг. Не разрешено использовать выражения, описывающие, что вы делаете какую-то работу лучше кого-то, или лучше всех. Не разрешено - оставлять свои контактные данные</p>
					<?= $form->field($model, 'about')->textarea(['rows'=>5]) ?>
				</div>
				
				<div class="col-lg-12">
					<p class="education-field-descr field-descr">Учреждение, специальность, год окончания. Перечислите через запятую.</p>
					<?= $form->field($model, 'education')->textarea(['rows'=>5]) ?>
				</div>
				<div class="col-lg-12"></div>
			</div>
			
			<?= $form->field($model, 'experience')->textarea(['rows'=>5]) ?>

			<p class="specialization-field-descr field-descr">Опишите тот вид работы, который вам удается особенно хорошо. Например - "могу подготовить к экзамену по физике твердого тела за три дня" или "отлично разбираюсь в гидравлической системе ситроен ксантиа."</p>
			
			<?= $form->field($model, 'specialization') ?>

			<?= $form->field($model, 'to_client')->checkbox() ?>
		</div>
		
		<div class="profile_anketa_row">
			<?= $this->render('_categories-block', ['form'=>$form, 'model'=>$model, 'categories'=>$categories, 'categories_l3'=>$categories_l3, 'model_name'=>'ProfileAnketaForm' ])?>
		</div>

		<div class="profile_anketa_row row clearfix">
			<div class="col-lg-6">
				<div id="uploading-avatar" class="form-group clearfix">
					<div class="row clearfix">
						<div class="col-lg-7">
							<?/*<label class="reg-step2-uploading-ttl"><?php echo $model->getAttributeLabel('avatar'); ?></label> */?>
							<?= $form->field($model, 'avatar')->hiddenInput() ?>
							<p class="uploading-info">Отличное качество, форматы jpg, jpeg, png, gif, размер не менее 1024х768px, до 5МБ</p>

							<div class="row clearfix">
								<div class="col-lg-7">
									<span id="upload-avatar-btn" class="button-red">Загрузить</span>
								</div>
								<div class="col-lg-5">
									<img id="loading-avatar" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
								</div>
								<div class="col-lg-12">
									<p id="loading-avatar-errormes" class="reg-step2-loading-errors"></p>
								</div>
							</div>
						</div>
						<div class="col-lg-5">
							<span id="avatar-cnt">
								<?php if($model->avatar) echo Html::a(Html::img(DImageHelper::getImageUrl($model->avatar, 'avatars', 1), ['class'=>'img-responsive']), DImageHelper::getImageUrl($model->avatar, 'avatars', 0), ['class' => '', 'data-toggle' => 'lightbox']) ?>
							</span>
						</div>
					</div>
				</div>
			</div>
		
			<div class="col-lg-6">
				<div id="uploading-price" class="form-group row clearfix">
					<div class="col-lg-4">
						<?= $form->field($model, 'price_list')->hiddenInput() ?>
					</div>
					<div class="col-lg-8">
						<?//= Html::a($model->price_list, 'http://team.by/'.Yii::$app->params['pricelists-path'].'/'.$model->price_list)?>
						<?= Html::a($model->price_list, DImageHelper::getImageUrl($model->price_list, 'pricelists', 0))?>
					</div>
					<div class="col-lg-4" style="clear:both;">
						<span id="upload-price-btn" class="button-red">Загрузить</span>
					</div>

					<div class="col-lg-5">
						<p class="uploading-info">Файл .XLS, .CSV, XLSX объемом не более 10МБ</p>
					</div>

					<div class="col-lg-2">
						<img id="loading-price" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
						<span id="loading-price-success" class="reg-step2-loading-price-success">Загружено</span>
					</div>

					<p id="loading-price-errormes" class="reg-step2-loading-errors col-lg-12 "></p>
				</div>		
			</div>
		</div>
		
		<div class="row clearfix">
			<div class="col-lg-6">
				<div id="uploading-awards" class="form-group clearfix">
					<label class="reg-step2-uploading-ttl"><?php echo $model->getAttributeLabel('awards'); ?></label>
					<p class="uploading-info">Если вам есть чем гордиться - обязательно покажите это.<br>Отличное качество, форматы jpg, jpeg, png, gif, размер не менее 1024х768px, до 5МБ</p>

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
							<?php for ($x=0; $x<=9; $x++) { ?>
								<li class="item-<?= ($x+1) ?> pull-left <?php echo (!isset($model->awards[$x])) ? 'no-foto' : '' ?>" data-item="<?= ($x+1) ?>">
									<?php 
										if(isset($model->awards[$x]))	{
											//echo Html::a(Html::img('http://team.by/' . Yii::$app->params['awards-path'] . '/thumb_' .$model->awards[$x]), 'http://team.by/' . Yii::$app->params['awards-path'] .'/' .$model->awards[$x], ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'awardsimages']);
											echo Html::a(Html::img(DImageHelper::getImageUrl($model->awards[$x], 'awards', 1)), DImageHelper::getImageUrl($model->awards[$x], 'awards', 0), ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'awardsimages']);
											echo Html::a('×', '#', ['class' => 'remove-uploaded-file', 'data-file'=>$model->awards[$x]]);
											echo Html::input('hidden', 'ProfileAnketaForm[awards][]', $model->awards[$x]);
										}	else	{
											echo ($x+1);
										}	
									?>
								</li>
							<?php	}	?>
						</ul>
					</div>
				</div>		
		
			</div>
			
			<div class="col-lg-6">
				<div id="uploading-examples" class="form-group clearfix">
					<div class="<?= isset($errors['examples']) ? 'has-error' : '' ?>">
						<label class="reg-step2-uploading-ttl"><?php echo $model->getAttributeLabel('examples'); ?></label>
						<?= isset($errors['examples']) ? '<div class="help-block">'.$errors["examples"][0].'</div>' : '' ?>
					</div>

					<p class="uploading-info">Отличное качество, форматы jpg, jpeg, png, gif, размер не менее 1024х768px, до 5МБ</p>

					<div class="row clearfix">
						<div class="col-lg-4">
							<span id="upload-examples-btn" class="button-red">Загрузить</span>
						</div>

						<div class="col-lg-2">
							<img id="loading-examples" class="reg-step2-loading-process" src="/images/loading.gif" alt="Loading" />
						</div>

						<div class="col-lg-5">
							<p id="loading-examples-errormes" class="reg-step2-loading-errors col-lg-12"></p>
						</div>
					</div>

					<div id="uploading-examples-list" class="uploading-tmb-list">
						<ul>
							<?php for ($x=0; $x<=9; $x++) { ?>
								<li class="item-<?= ($x+1) ?> pull-left <?php echo (!isset($model->examples[$x])) ? 'no-foto' : '' ?>" data-item="<?= ($x+1) ?>">
									<?php 
										if(isset($model->examples[$x]))	{
											//echo Html::a(Html::img('http://team.by/' . Yii::$app->params['examples-path'] .'/thumb_' .$model->examples[$x]), 'http://team.by/' . Yii::$app->params['examples-path'] .'/' .$model->examples[$x], ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'examplesimages']);
											echo Html::a(Html::img(DImageHelper::getImageUrl($model->examples[$x], 'examples', 1)), DImageHelper::getImageUrl($model->examples[$x], 'examples', 0), ['class' => '', 'data-toggle' => 'lightbox', 'data-gallery'=>'awardsimages']);
											echo Html::a('×', '#', ['class' => 'remove-uploaded-file', 'data-file'=>$model->examples[$x]]);
											echo Html::input('hidden', 'ProfileAnketaForm[examples][]', $model->examples[$x]);
										}	else	{
											echo ($x+1);
										}	
									?>
								</li>
							<?php	}	?>
						</ul>
					</div>
				</div>		
		
			</div>
		</div>
		
		<p class="youtube-field-descr field-descr">Иногда проще один раз показать, чем сто раз написать. Здесь вы можете оставить ссылку на ваше видеообращение.</p>
		<?= $form->field($model, 'youtube') ?>
		
		
		<div class="mb-30">
			<?php if($model->youtube != '') echo DYoutubeHelper::getYoutubeBlock($model->youtube) ?>	
		</div>
		
		<div class="form-group pt-30">
			<?= Html::submitButton('Сохранить изменения', ['class' => 'button-red']) ?>
		</div>
	<?php ActiveForm::end(); ?>
	
	<div class="profile_delete_profile_cnt clearfix">
		Вы прямо сейчас можете разорвать договор публичной оферты и удалить свой аккаунт.
		<a href="<?= Url::to(['profile/delete'])?>" id="profile_delete_btn" class="profile_delete_btn">Удалить аккаунт</a>
	</div>
	

</div>
