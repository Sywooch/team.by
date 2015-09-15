<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\widgets\ActiveForm;

use yii\bootstrap\Modal;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;


use yii\widgets\Breadcrumbs;

use pro\assets\AppAsset;

//use pro\widgets\Alert;
use frontend\widgets\Alert;

//use yii\widgets\Alert;

use pro\widgets\ProfileHeader;

AppAsset::register($this);

$current_controller = Yii::$app->controller->id;
$current_action = Yii::$app->controller->action->id;

$show_header_row1 = true;
$show_header_row3 = false;

//if($current_controller == 'site' && $current_action == 'index') $show_header_row1 = true;
if($current_controller == 'site' && $current_action == 'index') $show_header_row3 = true;

$wrap_cnt_class = '';
if($current_controller == 'site' && ($current_action == 'index' || $current_action == 'reg' || $current_action == 'reg-step1' || $current_action == 'reg-step2' ))
	$wrap_cnt_class = 'wrap__cnt_main_page'

?>


<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
		<? //echo'<pre>';print_r($current_controller);echo'</pre>';//die;    ?>
		<? //echo'<pre>';print_r($current_action);echo'</pre>';//die;    ?>
    <?php $this->beginBody() ?>
    <div class="wrap wrap__pro">
		<div class="wrap__cnt <?= $wrap_cnt_class ?>">
			<div class="header">
				<?php //if($show_header_row1) echo $this->render('_header_row1', [], false, true); ?>
				
				<?php echo $this->render('_header_row2', [], false, true); ?>
				
			</div>
			
			<?php if(!\Yii::$app->user->isGuest && $current_controller == 'profile') echo ProfileHeader::widget() ?>
			
			<?php if(isset($this->params['breadcrumbs']))	{	?>
				<div class="breadcrumbs-cnt">
					<div class="container">
						<?= Breadcrumbs::widget([
							'homeLink' => false,
							'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
						]) ?>
					</div>
				</div>
			<?php	}	?>

			<div class="container <?php if($current_controller != 'site' && $current_action != 'index') echo 'container-inner' ?> ">
				<?= Alert::widget() ?>


				<?= $content ?>
			
			</div>
			
			<?php //if($current_controller == 'site' && $current_action == 'index') echo $this->render('_how_it_work', [], false, true); ?>
			
			<?php //if($current_controller == 'site' && $current_action == 'index') echo $this->render('_reviews_block', [], false, true); ?>


		</div>
    </div>

	<footer class="footer footer__pro">
		<?php if(($current_controller == 'profile') && ($current_action == 'index')) {	?>
			<img src="<?= Yii::$app->params['proUrl']?>/images/reg-img-left.png" alt="" class="site_reg__footer_img_left">
			<img src="<?= Yii::$app->params['proUrl']?>/images/reg-img-right.png" alt="" class="site_reg__footer_img_right">
		<?php 	}	?>
	
		<div class="container clearfix">
			<a href="<?php echo Yii::$app->params['homeUrl']; ?>" class="logo_bottom pull-left"><img src="/images/logo-pro-bottom.png" alt=""></a>


			<div class="footer__cnt">
				<?php

				
				echo Menu::widget([
					'items' => [
						//['label' => 'Условия использования', 'url' => '#'],
						['label' => 'О компании', 'url' => 'http://team.by/page/about'],
						['label' => 'Оплата', 'url' => ['/page/view', 'alias'=>'oplata']],
						['label' => 'Тарифы', 'url' => ['/page/view', 'alias'=>'tarify'], 'visible' => !Yii::$app->user->isGuest],
						['label' => 'Преимущества для специалистов', 'url' => ['/page/view', 'alias'=>'preimuschestva-dlya-spetsialistov'], 'visible' => Yii::$app->user->isGuest],
						//['label' => 'Черный список', 'url' => '#'],
					],
					'options' => [
						'class' => 'footer_menu__list',
					],
					'itemOptions'=> [
						'class' => 'footer_menu__item',
					]
				]);
				?>
				
				<?php echo $this->render('@frontend/views/layouts/_footer_info', [], false, true); ?>
				<p class="footer__info">
				ЧУП "Профибелтаун"<br>
				зарегистрировано 28.05.2015 Минским горисполкомом.<br> 
				УНП 192483697. Юр.адрес 220053,<br>
				г. Минск, ул. Ярошевичская, д. 33, помещение №19/10
				</p>
				<p class="created_by">Разработка сайта: <a href="http://www.medialine.by" target="_blank" title="Medialine.by">Medialine.by</a></p>
			</div>
			
			
			<div class="footer__buttons footer__buttons_pro">
				<p>
					<img src="<?= Yii::$app->params['proUrl']?>/images/raschet_h_50.jpg" alt="" />
					<img src="<?= Yii::$app->params['proUrl']?>/images/logo_IPAY_h_50.png" alt="" />
					<?/*
					<img src="http://team.by/images/iPay_life_h_50.png" alt="" />
					<img src="http://team.by/images/iPay_mts_h_50.png" alt="" />
					*/?>
				</p>
				<p class="footer-webpay">
					<a href="http://www.webpay.by" target="_blank"><img src="<?= Yii::$app->params['proUrl']?>/images/webpay_h_50.png" alt="" /></a>
					<img src="<?= Yii::$app->params['proUrl']?>/images/visa_h_50.png" alt="" />
					<img src="<?= Yii::$app->params['proUrl']?>/images/verified-by-visa_h_50.png" alt="" />
					<img src="<?= Yii::$app->params['proUrl']?>/images/mastercard-securecode_h_50.png" alt="" />
					<img src="<?= Yii::$app->params['proUrl']?>/images/mastercard_h_50.png" alt="" />
				</p>
			</div>
			
			<div class="footer__buttons footer__buttons_pro">
				<?php if (\Yii::$app->user->isGuest) {	?>
					<a href="<?= Url::toRoute('/site/login')?>" id="login-modal-footer" class="button-gray footer__login_btn">Вход в личный кабинет специалиста</a>
				<?	}	else	{	?>
					<?php $form = ActiveForm::begin(['action'=>['/site/logout']]); ?>						
						<a id="logout-btn-footer" class="button-gray footer__logout_btn" href="<?= Url::toRoute('/site/logout')?>">Выйти из системы</a>
					<?php ActiveForm::end(); ?>
				<?	}	?>
			</div>
			

		</div>
	</footer>
	<div class="modal fade"></div>
    <?php $this->endBody() ?>
    <script>
var $buoop = {vs:{i:9,f:25,o:12.1,s:7},c:2}; 
function $buo_f(){ 
 var e = document.createElement("script"); 
 e.src = "//browser-update.org/update.min.js"; 
 document.body.appendChild(e);
};
try {document.addEventListener("DOMContentLoaded", $buo_f,false)}
catch(e){window.attachEvent("onload", $buo_f)}
	</script>
</body>
</html>
<?php $this->endPage() ?>
	