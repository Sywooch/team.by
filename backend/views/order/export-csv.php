<?php
use yii\helpers\Html;


$this->title = 'Выгрузка данных по заказам в файл';
$this->params['breadcrumbs'][] = $this->title;

?>


<h1><?= Html::encode($this->title) ?></h1>

<div class="client-import">
    <p>
        <?= Html::a('Начать', ['export-go'], ['class' => 'btn btn-success']) ?>
    </p>


</div>