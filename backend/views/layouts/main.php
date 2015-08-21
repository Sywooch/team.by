<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\widgets\Alert;

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
        <?php
			
				NavBar::begin([
					'brandLabel' => Yii::$app->name,
					'brandUrl' => Yii::$app->homeUrl,
					'options' => [
						'class' => 'navbar-inverse navbar-fixed-top',
					],
				]);
				if (!\Yii::$app->user->isGuest) {
				$menuItems = [
					//['label' => 'Home', 'url' => ['/site/index']],
					['label' => 'Категории', 'url' => ['/category/index']],
					['label' => 'Регионы', 'url' => ['/region/index']],
					['label' => 'Заказы', 'url' => ['/order/index']],

					[
						'label' => 'Пользователи',
						'items' => [
							['label' => 'Пользователи', 'url' => ['/user/index']],
							['label' => 'Специалисты', 'url' => ['/spec/index']],
							['label' => 'Клиенты', 'url' => ['/client/index']],
						],
					],            

					['label' => 'Сообщения', 'url' => ['/toadministration/index']],

					['label' => 'Страницы', 'url' => ['/page/index']],

//					[
//						'label' => 'Доступ',
//						'items' => [
//							 ['label' => 'Роли', 'url' => ['/permit/access/role']],
//							 ['label' => 'Права доступа', 'url' => ['/permit/access/permission']],
//						],
//					],            
					
					[
						'label' => 'Выгрузка',
						'items' => [
							 ['label' => 'Клиенты', 'url' => ['/client/export-csv']],
							 ['label' => 'Специалисты', 'url' => ['/spec/export-csv']],
							 ['label' => 'Заказы', 'url' => ['/order/export-csv']],
						],
					],            
					
					['label' => 'Валюта', 'url' => ['/currency/index']],



					/*
					[
						'label' => 'Dropdown',
						'items' => [
							 ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
							 '<li class="divider"></li>',
							 '<li class="dropdown-header">Dropdown Header</li>',
							 ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
						],
					],            
					*/
				];

				if (Yii::$app->user->can('manager') || Yii::$app->user->can('admin')) {
					//$menuItems[] = ['label' => 'Пользователи', 'url' => ['/user/index']];
				}

				if (Yii::$app->user->isGuest) {
					$menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
				} else {
					$menuItems[] = [
						'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
						'url' => ['/site/logout'],
						'linkOptions' => ['data-method' => 'post']
					];
				}
				}	else	{
					$menuItems = [];
				}
				echo Nav::widget([
					'options' => ['class' => 'navbar-nav navbar-right'],
					'items' => $menuItems,
				]);
				NavBar::end();
			
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
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
