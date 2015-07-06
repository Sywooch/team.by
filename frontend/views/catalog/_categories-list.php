<?php

use frontend\components\AUrlManager;

?>
<ul class="row clearfix all_profi_list">
	<?php foreach($categories as $cat) {	?>
		<li class="col-lg-3 all_profi_list__l1_item">
			<p class="all_profi_list__l1__ttl profi_<?= $cat['id']?>"><a href="<?= (AUrlManager::createUrl(['catalog/category', 'category' => $cat['path']]))?>" class="all_profi_list__l1_item_url"><?= $cat['name']?></a></p>
			<?php if(count($cat['children']))	{	?>
				<ul class="all_profi_list__l2">
					<?php foreach($cat['children'] as $c) {	?>
						<li class="all_profi_list__l2_item"><a href="<?= (AUrlManager::createUrl(['catalog/category', 'category' => $c['path']]))?>" class="all_profi_list__l2_item_url"><?= $c['name']?></a></li>
					<?php }	?>
				</ul>
				<a href="<?= (AUrlManager::createUrl(['catalog/category', 'category' => $cat['path']]))?>" class="all_profi_list__show_all">Показать все специальности</a>
			<?php }	?>
		</li>

	<?php }	?>
</ul>
