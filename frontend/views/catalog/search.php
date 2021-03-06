<?php
/* @var $this yii\web\View */

use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ButtonDropdown;

use yii\widgets\ActiveForm;


$title = 'Поиск по сайту';
$this->title = $title .' | '. Yii::$app->params['sitename'];

$this->params['breadcrumbs'][] = ['label' => $title];
//echo'<pre>';print_r($catDataProvider->models);echo'</pre>';
?>



<h1><?= $title?></h1>


<?php $form = ActiveForm::begin(['id' => 'category-sort-sw', 'options'=>['class'=>'category-sort-sw ']]); ?>
	<input type="hidden" id="orderby" name="orderby" value="<?= $current_ordering['field']?>" />
<?php ActiveForm::end(); ?>

<?php if(count($catdataProvider->models))	{	?>
	<div class="catalog-category-children__list">
		<ul class="row clearfixt">
			<?php 
				$i = 1;
				foreach($catdataProvider->models as $k=>$c) {
					if(($i-1)%4 == 0) $clr = ' clear';
						else $clr = '';
					
					$i++;
					echo Html::tag('li', Html::a(Html::encode($c->name), ['catalog/category', 'category' => $c->path]), ['class' => 'col-lg-3 catalog-category-children__item' . $clr]);
				}
			?>
		</ul>
	</div>
<?php	}	?>


<div class="category-list-cnt">
	<div class="category-sort-cnt clearfix">
		<?/*
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
		*/?>
	</div>

	<?php
	echo ListView::widget( [
		'dataProvider' => $dataProvider,
		'itemView' => '_item',
		'summary' => '',
		'id' => 'items-list',
		'options' => ['class' => 'list-view catalog-category-list-view'],
		'itemOptions' => ['class'=>'catalog-category-list-item'],
		'layout' => '{pager}{items}{pager}',
		'viewParams'=> ['specials'=>$specials],
	] );
	?>

	<div class="category-sort-cnt clearfix">
		<?/*
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
		*/?>
	</div>
</div>