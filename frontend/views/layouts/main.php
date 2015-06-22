<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Tabs;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use yii\helpers\Url;
use yii\widgets\Menu;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
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

						<div class="show_specialists clearfix">
							<span class="show_specialists__ttl">Отображать профессионалов:</span>
							<div class="header__regions">
								<p id="header_regions__active" class="header_regions__active">Вся Беларусь</p>
								<div id="header_regions__list_cnt" class="header_regions__list_cnt">
									<ul class="header_regions__list">
									<li class="header_regions__item"><a href="#" data-region="1">Минская область</a></li>
									<li class="header_regions__item"><a href="#" data-region="2">Гомельская область</a></li>
									<li class="header_regions__item"><a href="#" data-region="3">Брестская область</a></li>
									<li class="header_regions__item"><a href="#" data-region="4">Гродненская область</a></li>
									<li class="header_regions__item"><a href="#" data-region="5">Витебская область</a></li>
									<li class="header_regions__item"><a href="#" data-region="6">Могилёвская область</a></li>
								</ul>
								</div>
							</div>
						</div>

						<div class="currency_select">
							<p class="currency_select__ttl">Выбор валюты:</p>
							<div class="currency_select__list_cnt">
								<ul class="currency_select__list">
									<li class="currency_select__item currency_select__byr_active"><a href="#">BYR</a></li>
									<li class="currency_select__item currency_select__usd_active_"><a href="#">USD</a></li>
								</ul>
							</div>
						</div>

						<div class="autorization_h">
							<ul class="autorization_h__list">
								<li class="autorization_h__item autorization_h__item_reg_spec"><a class="autorization_h__reg_spec" href="#">Стать специалистом</a></li>
								<li class="autorization_h__item autorization_h__item_login"><a class="autorization_h__login" href="#">Войти</a></li>
							</ul>
						</div>
					</div>
				</div>

				<div class="header__row2">
					<div class="container">
						<div class="row clearfix">
							<div class="col-lg-5">
								<a href="#" class="logo_top">
									<img class="logo_top__img" src="<?php echo Url::to('@web'); ?>/images/logo-top.png" alt="Профессионалы">
									<span class="logo_top__cnt">
										<span class="logo_top__sitename">Профессионалы</span>
										<span class="logo_top__slogan">Только проверенные специалисты</span>
									</span>
								</a>
							</div>


							<div class="col-lg-5 col-lg-offset-2">
								<div class="header_phone">
									<div class="header_phone__txt"><span class="bold">Единый номер для всех</span><br>мобильных операторов РБ:</div>
									<div class="header_phone__number"><span class="header_phone__number_cnt">345-89-98</span></div>
								</div>
							</div>

						</div>
					</div>
				</div>

				<div class="header__row3">
					<div class="container">
						<span class="header_popular__ttl">Популярные категории</span>


						<?php 
						echo Nav::widget([
						'options' => [
						'class' => 'navbar-nav navbar-left header_navbar'
						],
						'items' => [
						'<li><a href="#" class="header_navbar__item"><span>Репетиторы</span>учителя и лекторы</a></li>',
						'<li><a href="#" class="header_navbar__item"><span>Артисты</span>певцы и ведущие</a></li>',
						'<li><a href="#" class="header_navbar__item"><span>Мастера красоты</span>учителя и ученики</a></li>',
						'<li><a href="#" class="header_navbar__item"><span>Фотографы</span>Свадебные съемки</a></li>',
						'<li><a href="#" class="header_navbar__item"><span>Спортивные тренеры</span>индивидуальные тренера</a></li>',
						]
						]);				   
						?>
					</div>
				</div>
			</div>


			<div class="profi_search">
				<div class="container">
					<div class="col-lg-10 col-lg-offset-1">
						<div class="profi_search__cnt">

							<p class="profi_search__ttl">Бесплатный подбор профессионалов по вашим критериям</p>

							<div class="profi_search__tabs">
								<?php 
								echo Tabs::widget([
									'items' => [
										[
											'label' => 'Найти специалиста',
											'content' => $this->render('_tab1', [], false, true),
											'active' => true
										],
										[
											'label' => 'Заказать подбор специалиста',
											'content' => $this->render('_tab2', [], false, true),
										],
									]
								]);			

								?>        

							</div>
						</div>
					</div>
				</div>
			</div>

			<?php
			//echo'<pre>';print_r($this);echo'</pre>';
	/*
				NavBar::begin([
					'brandLabel' => 'My Company',
					'brandUrl' => Yii::$app->homeUrl,
					'options' => [
						'class' => 'navbar-inverse navbar-fixed-top',
					],
				]);
				$menuItems = [
					['label' => 'Home', 'url' => ['/site/index']],
					['label' => 'About', 'url' => ['/site/about']],
					['label' => 'Contact', 'url' => ['/site/contact']],
				];
				if (Yii::$app->user->isGuest) {
					$menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
					$menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
				} else {
					$menuItems[] = [
						'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
						'url' => ['/site/logout'],
						'linkOptions' => ['data-method' => 'post']
					];
				}
				echo Nav::widget([
					'options' => ['class' => 'navbar-nav navbar-right'],
					'items' => $menuItems,
				]);
				NavBar::end();
				*/
			?>

			<div class="container">
			<?= Breadcrumbs::widget([
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			]) ?>
			<?= Alert::widget() ?>


			<?= $content ?>

			</div>

			<div class="how_it_work">
				<div class="container">
					<p class="h1">Как это работает</p>
					<div class="row clearfix">
						<div class="col-lg-4">
							<div class="how_it_work__1_cnt">
								<img src="<?php echo Url::to('@web'); ?>/images/how-it-work-1.png" alt="как это работает" class="how_it_work__img" />
								<p class="how_it_work__txt">Выберите необходимую услугу<br>и ваш регион </p>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="how_it_work__2_cnt">
								<img src="<?php echo Url::to('@web'); ?>/images/how-it-work-2.png" alt="как это работает" class="how_it_work__img" />
								<p class="how_it_work__txt">Выберите профессионала и отправьте нам <a href="#">заявку одним кликом</a> или<br>телефонным звонком  <span class="how_it_work__phone">8 ( 033 ) 875-15-12</span></p>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="how_it_work__3_cnt">
								<img src="<?php echo Url::to('@web'); ?>/images/how-it-work-3.png" alt="как это работает" class="how_it_work__img" />
								<p class="how_it_work__txt">Специалист свяжется с вами</p>
							</div>
						</div>
					</div>

					<div class="how_it_work__bottom">Наша помощь по выбору специалистов всегда бесплатна!</div>
				</div>
			</div>

			<div class="reviews_block">
				<div class="container">
					<p class="h1 reviews_block__ttl">Отзывы о специалистах</p>
					<div class="reviews_block__cnt">
						У каждого нашего клиента мы запрашиваем отзыв о работе специалиста. Отзыв могут оставить только наши клиенты, поэтому все отзывы у нас настоящие. Отзывы клиентов публикуются без редактирования, как есть. Негативные отзывы не удаляются.
					</div>
					<a href="#" class="button-red reviews_block__send">Оставить отзыв о специалисте</a>
				</div>
			</div>
		</div>
    </div>

	<footer class="footer">
		<div class="container">
			<a href="<?php echo Url::to('@web'); ?>" class="logo_bottom pull-left"><img src="<?php echo Url::to('@web'); ?>/images/logo-bottom.png" alt=""></a>


			<div class="footer__cnt">
				<?php
				echo Menu::widget([
					'items' => [
						['label' => 'Условия использования', 'url' => '#'],
						['label' => 'Правовые документы', 'url' => '#'],
						['label' => 'О компании', 'url' => '#'],
						['label' => 'Чёрный список', 'url' => '#'],
					],
					'options' => [
						'class' => 'footer_menu__list',
					],
					'itemOptions'=> [
						'class' => 'footer_menu__item',
					]
				]);
				?>
			</div>


		</div>
	</footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
