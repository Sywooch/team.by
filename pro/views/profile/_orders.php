<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ButtonDropdown;

use yii\widgets\ActiveForm;

use yii\widgets\Pjax;

?>




<div class="profile_orders">
<?php $form = ActiveForm::begin(['id' => 'orders-sort-sw', 'options'=>['class'=>'orders-sort-sw ']]); ?>
	<input type="hidden" id="orderby" name="orderby" value="<?= $current_ordering['field']?>" />
<?php ActiveForm::end(); ?>

	<div class="profile_orders_row orders-sort-cnt">
		<p class="category-sort-lbl">Сортировать по:</p>
		<?php echo ButtonDropdown::widget([
			'label' => $current_ordering['name'],
			'options' => [
				'class' => 'btn-lg btn-link',
				'style' => ''
			],
			'containerOptions' => [
				'class' => 'sorting-switcher',
			],
			'dropdown' => [
				'items' => $ordering_items
			]
		]);
		?>
		
	</div>
	
	<?php Pjax::begin(); ?>
		<?php echo ListView::widget( [
			'dataProvider' => $dataProvider,
			'itemView' => '_item-order',
			'summary' => '',
			'id' => 'orders-list',
			'options' => ['class' => 'list-view profile-orders-list-view clearfix'],
			'itemOptions' => ['class'=>'profile_orders_row profile_order_item'],
			'layout' => '{items}{pager}',
			//'viewParams'=> ['specials'=>$specials],
		]);?>
	<?php Pjax::end(); ?>
</div>