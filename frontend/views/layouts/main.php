<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\bootstrap\Modal;

use frontend\widgets\Regions;
use frontend\widgets\Currency;
use frontend\widgets\PopularCategories;
use frontend\widgets\ProfiSearch;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

$current_controller = Yii::$app->controller->id;
$current_action = Yii::$app->controller->action->id;

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
    <?php $this->beginBody() ?>
    <div class="wrap">
		<div class="wrap__cnt">
			<div class="header">
				<div class="header__row1">
					<div class="container clearfix">
				        
				        <?= Regions::widget() ?>
				        
				        <?= Currency::widget() ?>
				        
						<div class="autorization_h">
							<ul class="autorization_h__list">
								<li class="autorization_h__item autorization_h__item_reg_spec"><a class="autorization_h__reg_spec" href="#">Стать специалистом</a></li>
								<li class="autorization_h__item autorization_h__item_login"><a id="login-modal" class="autorization_h__login" href="<?=Url::toRoute('/site/login')?>">Войти</a></li>
							</ul>
						</div>
					</div>
				</div>

				<div class="header__row2">
					<div class="container">
						<div class="row clearfix">
							<div class="col-lg-5">
								<a href="<?php echo Yii::$app->params['homeUrl']; ?>" class="logo_top">
									<img class="logo_top__img" src="/images/logo-top.png" alt="Профессионалы">
									<span class="logo_top__cnt">
										<span class="logo_top__sitename">Профессионалы</span>
										<span class="logo_top__slogan">Только проверенные специалисты</span>
									</span>
								</a>
							</div>

							<div class="col-lg-5 col-lg-offset-2">
								<div id="header_phone" class="header_phone">
									<div class="header_phone__txt"><span class="bold">Единый номер для всех</span><br>мобильных операторов РБ:</div>
									<div class="header_phone__number"><span class="header_phone__number_cnt">345-89-98</span></div>
									<div id="header_phone__popup" class="header_phone__popup popup_block">
										<ul class="header_phone_popup__list">
											<li class="header_phone_popup__item header_phone_popup__phone">+375 (17) <span>345-89-98</span></li>
											<li class="header_phone_popup__item header_phone_popup__velcom">+375 (33) <span>345-89-98</span></li>
											<li class="header_phone_popup__item header_phone_popup__mts">+375 (44) <span>345-89-98</span></li>
											<li class="header_phone_popup__item header_phone_popup__life">+375 (29) <span>345-89-98</span></li>
										</ul>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>

				<div class="header__row3">
					<?= PopularCategories::widget() ?>
				</div>
			</div>

			<?php if($current_controller == 'site' && $current_action == 'index') echo ProfiSearch::widget() ?>

			<div class="container">
				<?= Breadcrumbs::widget([
					'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
				]) ?>
				<?= Alert::widget() ?>


				<?= $content ?>
			
			</div>
			
			<?php if($current_controller == 'site' && $current_action == 'index') echo $this->render('_how_it_work', [], false, true); ?>
			
			<?php if($current_controller == 'site' && $current_action == 'index') echo $this->render('_reviews_block', [], false, true); ?>


		</div>
    </div>

	<footer class="footer">
		<div class="container clearfix">
			<a href="<?php echo Yii::$app->params['homeUrl']; ?>" class="logo_bottom pull-left"><img src="/images/logo-bottom.png" alt=""></a>


			<div class="footer__cnt">
				<?php
				echo Menu::widget([
					'items' => [
						//['label' => 'Условия использования', 'url' => '#'],
						['label' => 'Правовые документы', 'url' => '#'],
						//['label' => 'О компании', 'url' => '#'],
						//['label' => 'Чёрный список', 'url' => '#'],
					],
					'options' => [
						'class' => 'footer_menu__list',
					],
					'itemOptions'=> [
						'class' => 'footer_menu__item',
					]
				]);
				?>
				
				<p class="footer__info">
					Единый номер для всех мобильных операторов РБ:  345-89-98<br>Время работы: 8:00 - 22:00
				</p>
				
				<p class="created_by">Разработка сайта: <a href="http://www.medialine.by" target="_blank" title="Medialine.by">Medialine.by</a></p>
			</div>
			
			<div class="footer__buttons">
				<a href="#" class="button-gray footer__reg_btn">Стать специалистом</a>
				<a href="#" class="button-gray footer__login_btn">Вход в личный кабинет специалиста</a>
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
	