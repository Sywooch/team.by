<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\DPriceHelper;
$polucheno = count($model->orders);
$vipolneno = 0;
$oplacheno = 0;
$vrabote = 0;
$total_summ = 0;
$total_fee = 0;
foreach($model->orders as $order)	{
    if($order->status == 2) $vrabote++;
    if($order->status == 3) $vipolneno++;
    if($order->payment_status == 10 && $order->status == 4) {
        $oplacheno++;
        $total_fee += $order->fee;
    }

    $total_summ += $order->price;

}
?>


<div class="tab_pane_cnt">

    <div class="form-group ">
        <label class="control-label">Номера заказов</label>

        <ul>
            <?php foreach($model->orders as $order)	{	?>
                <li><a href="<?= Url::to(['order/update', 'id'=>$order->id]) ?>"><?= $order->id ?></a></li>
            <?php	}	?>
        </ul>
    </div>


    <div class="form-group">
        <label class="control-label">Статистика по заказам</label>
        <table class="table">
            <thead>
            <tr>
                <th style="text-align:center;">В работе</th>
                <th style="text-align:center;">Выполнено</th>
                <th style="text-align:center;">Оплачено</th>
                <th style="text-align:center;">Получено</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td align="center"><?= $vrabote?></td>
                <td align="center"><?= $vipolneno?></td>
                <td align="center"><?= $oplacheno?></td>
                <td align="center"><?= $polucheno?></td>
            </tr>
            </tbody>
        </table>
    </div>


    <div class="form-group">
        <label class="control-label">Оплаты</label>
        <ul>
            <li>Заказов взято на <?= DPriceHelper::formatPrice($total_summ); ?></li>
            <li>Произведено выплат на <?= DPriceHelper::formatPrice($total_fee); ?></li>
        </ul>
    </div>
</div>