<?php

use frontend\components\AUrlManager;

$AUrlManager = new AUrlManager();
$i = 1;
?>
<ul class="row clearfix all_profi_list">
	<?php foreach($categories as $cat) {	?>
<?php
	if(($i-1)%4 == 0) {
		$clr = ' clear';
	//}	elseif(($k)%4 == 0 && $k >5)	{
	//	$clr = ' clear';
	}	else	{
		$clr = '';
	}
					
			
?>			
	
		<li class="col-lg-3 all_profi_list__l1_item <?= $clr?>">
			<p class="all_profi_list__l1__ttl profi_<?= $cat['id']?>"><a href="<?= (\Yii::$app->urlManager->createUrl(['catalog/category', 'category' => $cat['path']]))?>" class="all_profi_list__l1_item_url"><?= $cat['name']?></a></p>
			<?php if(count($cat['children']))	{	?>
				<ul class="all_profi_list__l2">
					<?php foreach($cat['children'] as $k=>$c) {	?>
						<li class="all_profi_list__l2_item"><a href="<?= (\Yii::$app->urlManager->createUrl(['catalog/category', 'category' => $c['path']]))?>" class="all_profi_list__l2_item_url"><?= $c['name']?></a></li>
						<?php if($k == 4) break; ?>
					<?php }	?>
				</ul>
				<a href="<?= (\Yii::$app->urlManager->createUrl(['catalog/category', 'category' => $cat['path']]))?>" class="all_profi_list__show_all">Показать все специальности</a>
			<?php }	?>
		</li>
		<?php $i++;	?>
	<?php }	?>
</ul>
