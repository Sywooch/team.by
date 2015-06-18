<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Tabs;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
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
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        
<?php 
echo Tabs::widget([
    'items' => [
        [
            'label' => 'Yii2',
            'content' => '<h2>Фреймворк Yii 2 - один из самых быстрых, безопасных и "крутых" php-фреймворков.</h2>',
            'active' => true
        ],
        [
            'label' => 'jQuery',
            'content' => '<h2>jQuery - один из самых популярных JavaScript фреймворков, который работает с объектами DOM.</h2>'
        ],
        [
            'label' => 'Bootstrap',
            'content' => '<h2>Twitter Bootstrap - супер фреймворк, объединяющий в себе html, css, и JavaScript для для верстки веб-интерфейсов и страниц.</h2>',
            'headerOptions' => [
                'id' => 'headerOptions'
            ],
            'options' => [
                'id' => 'options'
            ]
        ],
        [
            'label' => 'Еще табы',
            'content' => '<h2>Вы можете добавить любое количество табов. Просто опишите их структуру в массиве.</h2>'
        ],
        [
            'label' => 'Выпадающий список табов',
            'items' => [
                [
                    'label' => 'Первый таб из выпадающего списка',
                    'content' => '<h2>Обновите свои познания в Yii 2 and Twitter Bootstrap. Все возможнсти уже обернуты в удобные интерфейсы.</h2>'
                ],
                [
                    'label' => 'Второй таб из выпадающего списка',
                    'content' => '<h2>Один в поле не воин, а двое - уже компания.</h2>'
                ],
                [
                    'label' => 'Это третий таб из выпадающего списка',
                    'content' => '<h2>Третий не лишний!</h2>'
                ]
            ]
        ]
    ]
]);			
			
?>        
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
