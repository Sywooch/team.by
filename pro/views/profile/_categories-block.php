<?php

use yii\helpers\Html;
\frontend\assets\PriceInputAsset::register($this);

if($_SERVER['REMOTE_ADDR'] == '93.125.44.252') {
	//echo'<pre>';print_r($categories);echo'</pre>';//die;
	//echo'<pre>--------------------------------</pre>';//die;
	//echo'<pre>';print_r($categories_l3);echo'</pre>';//die;
}

//echo $model_name;
?>

<?php 
	if($show_all === true) echo $form->field($model, 'category1')->dropDownList($model->categoriesLevel1DropDownList, [$model->category1, 'prompt'=>'Я оказываю услуги из раздела...']);
		else echo Html::activeHiddenInput($model, 'category1');

//return;
//var_dump($model->category1);
if(!is_null($model->category1)) $show_all = false;
?>

<div id="subcat-cnt">
<?php foreach($categories as $cat1)	{	?>
	<?php if(is_null($model->category1)) break; ?>
	<?php if($show_all === false && $model->category1 != $cat1['id']) continue;  ?>
	<div id="category-block-<?= $cat1['id']?>" class="categories-block" <?php if($model->category1 == $cat1['id']) echo 'style="display:block;"' ?> >
		<p><?php echo $cat1['name']?></p>
		<?php if(count($cat1['children']))	{	?>
			<?php $col1 = $col2 = '';?>

				<?php

					//print_r($categories_l3);
					foreach($cat1['children'] as $i=>$cat2)	{
						//print_r($cat2['id']);
						$inner_li = Html::checkbox(
							$model_name.'[categories][]', 
							$model->isChecked($cat2['id']), 
							[
								'label' => $cat2['name'], 
								'labelOptions'=> [
									'class'=> ($model->isChecked($cat2['id']) ? 'category-block-checked' : ''),
								],
								'value'=>$cat2['id'], 
								'id'=>'category-'.$cat2['id'], 
								'class'=>'reg-step2-category',
							]
						);


						if(isset($categories_l3[$cat2['id']]))	{
							$inner_li .= '<ul id="cnt-price-'.$cat2['id'].'"'. (!$model->isChecked($cat2['id']) ? ' style="display:none;"': '') .'>';
							foreach($categories_l3[$cat2['id']] as $child_k => $child)	{
								/*
								if($cat1['id'] == 2) $cl = 'col-sm-5';
									else $cl = 'col-sm-7';
								*/
								$cl = 'col-sm-5';
								
								$inner_li .= '<li id="usluga-price-'.$child_k.'" class="form-group clearfix">';
								$inner_li .= '<div class="'.$cl.' categories-block-lbl-cnt">';
								$inner_li .= Html::checkbox(
									$model_name.'[usluga][]', 
									$model->uslugaIsCheked($child_k), 
									[
										'label' => $child,
										'labelOptions'=> [
											'class'=> 'control-label',
										],

										'value'=>$child_k, 
										'id'=>'usluga-'.$child_k
									]
								);
								$inner_li .= '</div>';
								$inner_li .= '<div class="col-sm-3">';
								$inner_li .=  Html::textInput( $model_name.'[price]['.$child_k.']', isset($model->price[$child_k]) ? $model->price[$child_k] : '', ['class'=>"form-control price-input", 'id'=>'price-'.$child_k, 'placeholder'=>'Стоимость'] );
								$inner_li .= '</div>';
								
								$inner_li .= '<div class="col-sm-2 profile-uslugi-currency">';
								$inner_li .= ' бел.руб';
								
								//if($cat1['id'] == 2) $inner_li .= '<span class="profile-unit-ttl">за<span>';
								$inner_li .= '<span class="profile-unit-ttl">за<span>';
								
								$inner_li .= '</div>';
								/*
								if($cat1['id'] == 2) {
									$inner_li .= '<div class="col-sm-2">';
									$inner_li .=  Html::textInput( $model_name.'[unit]['.$child_k.']', isset($model->unit[$child_k]) ? $model->unit[$child_k] : '', ['class'=>"form-control", 'id'=>'price-'.$child_k, 'placeholder'=>'за'] );
									$inner_li .= '</div>';
								}
								*/

								$inner_li .= '<div class="col-sm-2">';
								$inner_li .=  Html::textInput( $model_name.'[unit]['.$child_k.']', isset($model->unit[$child_k]) ? $model->unit[$child_k] : '', ['class'=>"form-control", 'id'=>'price-'.$child_k, 'placeholder'=>'за'] );
								$inner_li .= '</div>';

								$inner_li .= '</li>';
							}
							$inner_li .= '</ul>';
						}
						$elem = Html::tag('li', $inner_li/*, ['class'=>'col-lg-611']*/ );
						
						$col1 .= $elem;

//						if ($i % 2 == 0) {
//							$col1 .= $elem;
//						}	else	{
//							$col2 .= $elem;
//						}

					}	
				?>
				<?/*<div class="row clearfix">
					<div class="col-lg-12">*/?>
						<ul <?/*class="row1 clearix1"*/?>>
							<?= $col1 ?>
						</ul>
					<?/*</div>
				</div>*/?>

		<?php	}	?>
	</div>
	
	<?php if($show_all === false && $model->category1 == $cat1['id']) break;  ?>
	
<?php	}	?>
</div>