<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $form yii\widgets\ActiveForm */

//echo'<pre>';print_r($_SERVER);echo'</pre>';
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>
		<?php 
		echo Tabs::widget([
			'items' => [
				[
					'label' => 'Основное',
					'content' => $this->render('_form-main', ['model' => $model, 'form' => $form]),
					'active' => true,
				],
				[
					'label' => 'Meta',
					'content' => $this->render('_form-meta', ['model' => $model, 'form' => $form]),
				],
			]
		]);			

		?>        


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
