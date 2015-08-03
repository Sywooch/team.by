<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Специалист : ' . ' ' . $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Специалисты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-update">

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
