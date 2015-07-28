<?php
use yii\bootstrap\Tabs;
?>

<div class="profi_search">
	<div class="container">
		<div class="col-lg-10 col-lg-offset-1">
			<div class="profi_search__cnt">

				<p class="profi_search__ttl">Бесплатный подбор профессионалов по вашим критериям</p>

				<div class="profi_search__tabs">
					<?php 
					echo Tabs::widget([
						'items' => [
							[
								'label' => 'Найти специалиста',
								'content' => $this->render('_profi_search_tab1', ['regions'=>$regions, 'region_str'=>$region_str, 'region_id'=>$region_id], false, true),
								'active' => true,
								'linkOptions' => ['class' => 'profi_search_tabs__tab1'],
							],
							[
								'label' => 'Заказать подбор специалиста',
								'content' => $this->render('_profi_search_tab2', ['model'=>$model], false, true),
								'linkOptions' => ['class' => 'profi_search_tabs__tab2'],
								'options' => ['class' => 'profi_search_tab__zakaz']
							],
						]
					]);			

					?>        

				</div>
			</div>
		</div>
	</div>
</div>
