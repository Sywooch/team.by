<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<div class="profi_search_inner">
	<div class="container">
		<div class="row clearfix">
			<div class="col-lg-3">
				<div id="profi_search_inner_catalog">
					<?php if($controller == 'catalog' && $action == 'black-list')	{	?>
						<a href="<?= \Yii::$app->urlManager->createUrl(['catalog'])?>" class="profi_search_inner_catalog_url">Каталог специалистов<span class=""> </span></a>
					<?php	}	else	{	?>
					
					
						<span class="profi_search_inner_catalog">Каталог специалистов<span class=""> </span></span>

						<div id="catalog_popup" class="catalog_popup">
							<ul class="row clearfix all_profi_list">
								<?php foreach($categories as $cat) {	?>
									<li class="col-lg-3 all_profi_list__l1_item">
										<p class="all_profi_list__l1__ttl profi_<?= $cat['id']?>"><a href="<?= (\Yii::$app->urlManager->createUrl(['catalog/category', 'category' => $cat['path']]))?>" class="all_profi_list__l1_item_url"><?= $cat['name']?></a></p>
										<?php if(count($cat['children']))	{	?>
											<ul class="all_profi_list__l2">
												<?php foreach($cat['children'] as $c) {	?>
													<li class="all_profi_list__l2_item"><a href="<?= (\Yii::$app->urlManager->createUrl(['catalog/category', 'category' => $c['path']]))?>" class="all_profi_list__l2_item_url"><?= $c['name']?></a></li>
												<?php }	?>
											</ul>
										<?php }	?>
									</li>
								<?php }	?>
							</ul>
						</div>
					<?php	}	?>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="profi_search_inner__inputbox_cnt clearfix">
					<?php $form = ActiveForm::begin(['action'=>\Yii::$app->urlManager->createUrl(['catalog/search']), 'method'=>'get']); ?>
						<input type="hidden" id="profi_search_region_id" name="region_id" value="<?= $region_id?>" />
						<input type="text" id="profi_search_input" class="inputbox profi_search_inner__inputbox" name="profi_search" value="<?= Html::encode($search_qry)?>" placeholder="Введите специальность или услугу">
				
						<?/*<input type="text" class="inputbox profi_search_inner__inputbox" value="" placeholder="Введите специальность или услугу">*/?>
						<div class="profi_search_inner__regions">
							<span id="profi_search_regions__active" class="profi_search_inner_regions__active"><?= $region_str?></span>
							<div id="profi_search_regions__list_cnt" class="profi_search_regions__list_cnt popup_block">
								<ul class="profi_search_regions__list">
									<?php foreach($regions as $row)	{	?>
										<li class="profi_search_regions__item">
											<a href="javascript:void(0)" <?=  $row['active'] ? 'class="profi_search_regions__item_active"' : '' ?> data-region="<?= $row['id']?>"><?= $row['name']?></a>
											<?php if($row['children'])	{	?>
												<ul class="profi_search_regions_list__l2">
													<?php foreach($row['children'] as $row_c)	{	?>
														<li class="profi_search_regions__item profi_search_regions__item_l2">
															<a href="javascript:void(0)" <?= $row_c['active'] ? 'class="profi_search_regions__item_active"' : '' ?> data-region="<?= $row_c['id']?>"><?= $row_c['name']?></a>
														</li>
													<?	}	?>
												</ul>
											<?	}	?>
										</li>
									<?	}	?>
								</ul>
							</div>
					</div>
					<?php ActiveForm::end(); ?>					
				</div>
				

			</div>
			<div class="col-lg-3 profi_search_inner__button_col">
				<p class="profi_search_inner__button_cnt">
					<span class="button-red profi_search_inner__button contact-to-spec" data-contact="<?= Yii::$app->urlManager->createUrl(['site/zakaz-spec1'])?>">Заказать подбор специалиста</span>
				</p>
			</div>
		</div>
		
		
	</div>
</div>
