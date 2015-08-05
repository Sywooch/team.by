<?php
//use yii\helpers\Html;
//use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;
?>

<?php Pjax::begin(); ?>	
	<?php echo ListView::widget( [
		'dataProvider' => $dataProvider,
		'itemView' => '_item-review',
		'summary' => '',
		'id' => 'reviews-list',
		'options' => ['class' => 'list-view reviews_list profile-reviews-list-view clearfix'],
		'itemOptions' => ['class'=>'reviews_item'],
		'layout' => '{items}{pager}',
		//'viewParams'=> ['specials'=>$specials],
	]);?>
<?php Pjax::end(); ?>