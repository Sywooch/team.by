<?php
use yii\bootstrap\Tabs;
?>

<div class="profi_search_inner">
	<div class="container">
		<div class="row clearfix">
			<div class="col-lg-3">
				<a href="#" class="profi_search_inner_catalog">Каталог специалистов<span class=""> </span></a>
			</div>
			<div class="col-lg-6">
				<div class="profi_search_inner__inputbox_cnt clearfix">
					<input type="text" class="inputbox profi_search_inner__inputbox" value="" placeholder="Введите специальность или услугу">
						<div class="profi_search_inner__regions">
							<span id="profi_search_inner_regions__active" class="profi_search_inner_regions__active">Минск</span>
							<div id="profi_search_inner_regions__list_cnt" class="profi_search_regions__list_cnt popup_block">
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
				</div>
				

			</div>
			<div class="col-lg-3 profi_search_inner__button_col">
				<p class="profi_search_inner__button_cnt">
					<a id="profi_search_btn" class="button-red profi_search_inner__button" href="<?= Yii::$app->urlManager->createUrl(['site/zakaz-spec1'])?>">Заказать подбор специалиста</a>
				</p>
			</div>



		</div>
	</div>
</div>
