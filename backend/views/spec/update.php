<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Специалист : ' . ' ' . $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Специалисты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$documents_tmpl = '_documents-1';
switch($model->user_type) {
	case 1:
		$documents_tmpl = '_documents-1';
		break;
	case 2:
		$documents_tmpl = '_documents-2';
		break;
	case 3:
		$documents_tmpl = '_documents-3';
		break;
}
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>
    
		<?php 
		echo Tabs::widget([
			'items' => [
				[
					'label' => 'Анкета',
					'content' => $this->render('_form', ['model' => $model, 'document_form' => $document_form]),
					'active' => true,
				],
				[
					'label' => 'Фото / Видео',
					'content' => $this->render('_foto-video', ['model' => $model]),
				],
				[
					'label' => 'Документы',
					'content' => $this->render($documents_tmpl, ['model' => $document_form]),
				],
				[
					'label' => 'Перечень услуг',
					'content' => $this->render('_uslugi', ['model' => $model]),
				],
				[
					'label' => 'Заказы',
					'content' => $this->render('_orders', ['model' => $model]),
				],
				[
					'label' => 'Отзывы',
					'content' => $this->render('_reviews', ['model' => $model]),
				],
			]
		]);			

		?>        
    

</div>
