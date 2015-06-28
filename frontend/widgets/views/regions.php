<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<div class="show_specialists clearfix">
	<span class="show_specialists__ttl">Отображать профессионалов:</span>
	<div class="header__regions">
		<p id="header_regions__active" class="header_regions__active"><?= $region_str?></p>
		<div id="header_regions__list_cnt" class="header_regions__list_cnt popup_block popup_block_dark">
			
        	<?php $form = ActiveForm::begin(['action'=>\Yii::$app->urlManager->createUrl(['site/set-region']), 'id'=>'set-region-frm']); ?>
				<input type="hidden" name="return_url" value="<?= Url::to('')?>">
				<input type="hidden" id="region_id" name="region_id" value="<?= $region_id?>">
				<ul class="header_regions__list">
					<?php foreach($regions as $row)	{	?>
						<li class="header_regions__item">
							<a href="javascript:void(0)" <?=  $row['active'] ? 'class="header_regions_item_active"' : '' ?> data-region="<?= $row['id']?>"><?= $row['name']?></a>
							<?php if($row['children'])	{	?>
								<ul class="header_regions_list__l2">
									<?php foreach($row['children'] as $row_c)	{	?>
										<li class="header_regions__item header_regions__item_l2">
											<a href="javascript:void(0)" <?=  $row_c['active'] ? 'class="header_regions_item_active"' : '' ?> data-region="<?= $row_c['id']?>"><?= $row_c['name']?></a>
										</li>
									<?	}	?>
								</ul>
							<?	}	?>
						</li>
					<?	}	?>
				</ul>
			<?php ActiveForm::end(); ?>			
		</div>
	</div>
</div>
