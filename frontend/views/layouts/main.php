<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\widgets\ActiveForm;

use yii\bootstrap\Modal;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

use yii\widgets\Breadcrumbs;

use frontend\assets\AppAsset;

use frontend\widgets\Alert;

use frontend\widgets\ProfiSearch;
use frontend\widgets\ProfileHeader;
use frontend\widgets\TopLineWidget;
use frontend\assets\BootstrapLightboxAsset;

use common\models\User;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

BootstrapLightboxAsset::register($this);

$current_controller = Yii::$app->controller->id;
$current_action = Yii::$app->controller->action->id;

$show_header_row1 = true;
$show_header_row3 = false;

//if($current_controller == 'site' && $current_action == 'index') $show_header_row1 = true;
if($current_controller == 'site' && $current_action == 'index') $show_header_row3 = true;

$wrap_cnt_class = '';
if($current_controller == 'site' && ($current_action == 'index' || $current_action == 'reg' || $current_action == 'reg-step1' || $current_action == 'reg-step2' ))
	$wrap_cnt_class = 'wrap__cnt_main_page';
	
if($current_controller == 'catalog' && $current_action == 'black-list')
	$wrap_cnt_class = 'wrap__cnt_black_list';

?>


<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    
	<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="/favicon-194x194.png" sizes="194x194">
	<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="/android-chrome-192x192.png" sizes="192x192">
	<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="/manifest.json">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="apple-mobile-web-app-title" content="Team.by">
	<meta name="application-name" content="Team.by">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-TileImage" content="/mstile-144x144.png">
	<meta name="theme-color" content="#ffffff">    
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap <?= $wrap_cnt_class ?>">
		<div class="wrap__cnt">
			<div class="header">
				<?php if($show_header_row1) echo $this->render('_header_row1', [], false, true); ?>
				
				<?php echo $this->render('_header_row2', [], false, true); ?>
				
				<?php if($show_header_row3) echo $this->render('_header_row3', [], false, true); ?>
			</div>

			<?php echo ProfiSearch::widget(['controller'=>$current_controller, 'action'=>$current_action]) ?>
			
			<?php if(!\Yii::$app->user->isGuest && $current_controller == 'profile') echo ProfileHeader::widget() ?>
			
			<?php if(isset($this->params['breadcrumbs']))	{	?>
				<div class="breadcrumbs-cnt">
					<div class="container">
						<?= Breadcrumbs::widget([
							'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
						]) ?>
					</div>
				</div>
			<?php	}	?>

			<div class="container <?php if($current_controller != 'site' && $current_action != 'index') echo 'container-inner' ?> ">
				<?= Alert::widget() ?>


				<?= $content ?>
			
			</div>
			
			<?php if($current_controller == 'site' && $current_action == 'index') echo $this->render('_how_it_work', [], false, true); ?>
			
			<?php if($current_controller == 'site' && $current_action == 'index') echo $this->render('_reviews_block', [], false, true); ?>


		</div>
    </div>

	<footer class="footer">
		<?php if($current_controller == 'site' && $current_action == 'reg') {	?>
			<img src="/images/reg-img-left.png" alt="" class="site_reg__footer_img_left">
			<img src="/images/reg-img-right.png" alt="" class="site_reg__footer_img_right">
		<?php 	}	?>
		<div class="container clearfix">
			<a href="<?php echo Yii::$app->params['homeUrl']; ?>" class="logo_bottom pull-left"><img src="/images/logo-bottom.png" alt=""></a>


			<div class="footer__cnt">
				<?php
                
               
                $black_list_count = User::find()->where(['black_list'=>1])->andWhere(['<>', 'user_status', 3])->count();
                
                //echo $black_list_count;
                $items = [
						//['label' => 'Условия использования', 'url' => '#'],
						['label' => 'Наши преимущества', 'url' => ['/page/view', 'alias'=>'advantages']],
						['label' => 'О компании', 'url' => ['/page/view', 'alias'=>'about']],
						//['label' => 'О компании', 'url' => '#'],
						//['label' => 'Черный список', 'url' => ['catalog/black-list']],
				];
                if($black_list_count > 0)
                    $items[] = ['label' => 'Черный список', 'url' => ['catalog/black-list']];
                
				echo Menu::widget([
					'items' => $items,
					'options' => [
						'class' => 'footer_menu__list',
					],
					'itemOptions'=> [
						'class' => 'footer_menu__item',
					]
				]);
				?>
				
				<?php echo $this->render('_footer_info', [], false, true); ?>
								
				<p class="created_by">Разработка сайта: <a href="http://www.medialine.by" target="_blank" title="Medialine.by">Medialine.by</a></p>
			</div>
			
			<div class="footer__buttons">
				<?php if (\Yii::$app->user->isGuest) {	?>
					<a href="<?= Yii::$app->params['proUrl']?>" class="button-gray footer__reg_btn">Стать специалистом</a>
					<a href="<?= Url::toRoute('/site/login')?>" id="login-modal-footer" class="button-gray footer__login_btn">Вход в личный кабинет специалиста</a>
				<?	}	else	{	?>
					<?php $form = ActiveForm::begin(['action'=>['/site/logout']]); ?>						
						<a id="logout-btn-footer" class="button-gray footer__logout_btn" href="<?= Url::toRoute('/site/logout')?>">Выйти из системы</a>
					<?php ActiveForm::end(); ?>
				
				
					<?/*<a href="<?= Url::toRoute('/site/reg')?>" class="button-gray footer__reg_btn">Стать специалистом</a>*/?>
					<a href="http://pro.team.by" class="button-gray footer__login_btn">Вход в личный кабинет специалиста</a>
				<?	}	?>
			</div>


		</div>
	</footer>
	<div class="modal fade"></div>    
   
    <?php 
    //if($_SERVER['REMOTE_ADDR'] == '93.125.72.116') {
        if($current_controller == 'catalog') echo TopLineWidget::widget();
    //}
    ?>
    
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
    
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter32707725 = new Ya.Metrika({
                    id:32707725,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/32707725" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
    
</body>
</html>
<?php $this->endPage() ?>
	