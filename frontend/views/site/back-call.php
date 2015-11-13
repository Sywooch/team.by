<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $model frontend\models\ZakazSpec1 */
/* @var $form ActiveForm */

$this->title = 'Обратный звонок';

$countries_list = Yii::$app->params['countries'];
?>

<div class="modal-dialog modal-dialog__zakaz-spec1 modal-content">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h2 class="h2__modal"><?= Html::encode($this->title) ?></h2>
		</div>
		
		<div class="modal-body">
			<?php $form = ActiveForm::begin(); ?>
			    <div class="row">
			        <div class="col-lg-6">
			        	<div id="country-flag-dropdown" class="country-flag-dropdown">
			        		<ul id="country-flag-list" class="country-flag-list">
			        			<?php
									foreach($countries_list as $key=>$country)
										echo Html::tag ( 'li', (Html::tag('span', ' ', ['class'=>'cflag18 cflag-'.mb_strtolower($key)]) . $country['name'] . ' ' . $country['phone_prefix']), ['data-cc'=>$key, 'data-prefix'=>$country['phone_prefix'] ] );
								?>
			        		</ul>
			        		<span id="cfd-value" class="cfd-value">
			        			<span id="cc-active" class="cflag18 cflag-<?= $model->country_code ?>"></span>
			        		</span>
			        	</div>
			        	<??>
			        	<?= $form->field($model, 'phone')->textInput(['placeholder'=>'Номер телефона', 'class'=>'form-control phone-input']) ?>
			        	<?= $form->field($model, 'country_code')->hiddenInput(['class'=>'country_code'])->label(false) ?>
			        </div>
			        <div class="col-lg-6"><?= $form->field($model, 'name') ?></div>
			    </div>
              
                  <div class="row">
                      <div class="col-lg-6">
                        <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                            'template' => '<div class="row"><div class="col-lg-5">{image}</div><div class="col-lg-2"><img id="captcha-reload-bnt" src="http://team.by/images/reload-btn.png" title="Обновить картинку"></div><div class="col-lg-5">{input}</div></div>',
                        ]) ?>
                          
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group cleafrix">
                            <?= Html::submitButton('Отправить', ['id'=>'back-call-btn', 'class' => 'button-red']) ?>
                        </div>                          
                      </div>
                  </div>
               
			    
				
				

			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>


<script src="/assets/dd5f9f45/yii.captcha.js"></script>
<script type="text/javascript">jQuery(document).ready(function () {jQuery('#backcallform-verifycode-image').yiiCaptcha({"refreshUrl":"\/site\/captcha?refresh=1","hashKey":"yiiCaptcha\/site\/captcha"});jQuery('#captcha-reload-bnt').on('click', function(){jQuery('#backcallform-verifycode-image').click()});});</script>
