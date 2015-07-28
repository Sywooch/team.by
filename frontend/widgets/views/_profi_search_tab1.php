<?php

use yii\widgets\ActiveForm;
?>
<div class="profi_search_tab_1__cnt">
	<?php $form = ActiveForm::begin(['action'=>\Yii::$app->urlManager->createUrl(['ajax/profi-search'])]); ?>
		<input type="hidden" id="profi_search_tab_region_id" name="region_id" value="<?= $region_id?>" />
		<input type="text" id="profi_search_input" class="inputbox profi_search_tab_1__inputbox" name="profi_search" value="" placeholder="Введите специальность или услугу">
		<div class="profi_search_tab_1__region">
			<span class="profi_search_tab_1_region__ttl">Ваш регион:</span>
			<div class="profi_search_tab_1__regions">
				<span id="profi_search_tab_1_regions__active" class="profi_search_tab_1_regions__active"><?= $region_str?></span>
				<div id="profi_search_tab_1_regions__list_cnt" class="profi_search_tab_1_regions__list_cnt popup_block">
					<ul class="profi_search_tab_1_regions__list">
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

				<button class="button-red profi_search__button">Найти</button>
			</div>
		</div>
	<?php ActiveForm::end(); ?>
</div>
