<?php

use yii\helpers\Html;

use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model common\models\Client */

$this->title = 'Редактирование: ' . ' ' . $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Клинеты', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="client-update">

    <h1><?= Html::encode($this->title) ?></h1>

	<?php 
	echo Tabs::widget([
		'items' => [
			[
				'label' => 'Анкета',
				'content' => $this->render('_form', ['model' => $model]),
				'active' => true,
				'linkOptions' => ['class' => ''],
				'options' => ['class' => '']
			],
			[
				'label' => 'Заказы',
				'content' => $this->render('_orders', ['model' => $model]),
				'linkOptions' => ['class' => ''],
				'options' => ['class' => '']
			],
		]
	]);			

	?>        

</div>
