<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Tabs;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use yii\helpers\Url;

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
		<div class="header">
			<div class="header__row1">
				<div class="container clearfix">

					<div class="show_specialists clearfix">
						<span class="show_specialists__ttl">Отображать профессионалов:</span>
						<div class="header__regions">
							<div id="header_regions__active" class="header_regions__active">Вся Беларусь</div>
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
						<div class="currency_select__ttl">Выбор валюты:</div>
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
		<div class="profi_search">
			<p class="profi_search__ttl">Бесплатный подбор профессионалов по вашим критериям</p>
			
			<div class="profi_search__tabs">
				<?php 
				echo Tabs::widget([
					'items' => [
						[
							'label' => 'Yii2',
							'content' => $this->render('_tab1', [], false, true),
							'active' => true
						],
						[
							'label' => 'jQuery',
							'content' => '<h2>jQuery - один из самых популярных JavaScript фреймворков, который работает с объектами DOM.</h2>'
						],
					]
				]);			

				?>        
				
			</div>
		</div>
       
        
        <?= $content ?>
        
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
