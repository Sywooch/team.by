<?php
/* @var $this yii\web\View */

use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ButtonDropdown;

use yii\widgets\ActiveForm;

\frontend\assets\BootstrapLightboxAsset::register($this);


//echo'<pre>';print_r($specials);echo'</pre>';die;
//$this->title = Yii::$app->params['sitename'] .' | '. $parent->name .' | '. $category->name;

//echo'<pre>';print_r($dataProvider);echo'</pre>';

//$this->params['breadcrumbs'][] = ['label' => 'Regions', 'url' => ['index']];
$title_arr = [Yii::$app->params['sitename']];

$this->params['breadcrumbs'][] = ['label' => 'Каталог специалистов', 'url' => ['index']];

foreach($parents as $parent) {
	if($parent->id <> 1) {
		$this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => ['category', 'category'=>$parent->path]];
		$title_arr[] = $parent->name;
	}
		
}

$title_arr[] = $category->name;

$this->title = implode(' | ', $title_arr);

$this->params['breadcrumbs'][] = $category->name;



?>

<h1><?= $category->name?></h1>

<?php if(count($children))	{	?>
	<div class="catalog-category-children__list">
		<ul class="row clearfixt">
			<?php foreach($children as $c)	echo Html::tag('li', Html::a(Html::encode($c->name), ['catalog/category', 'category' => $c->path]), ['class' => 'col-lg-2 catalog-category-children__item']) ?>
		</ul>
	</div>
<?php	}	?>



<?php $form = ActiveForm::begin(['id' => 'category-sort-sw', 'options'=>['class'=>'category-sort-sw ']]); ?>
	<input type="hidden" id="orderby" name="orderby" value="<?= $current_ordering['field']?>" />
<?php ActiveForm::end(); ?>

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