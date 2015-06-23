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
								'content' => $this->render('_tab1', [], false, true),
								'active' => true
							],
							[
								'label' => 'Заказать подбор специалиста',
								'content' => $this->render('_tab2', [], false, true),
							],
						]
					]);			

					?>        

				</div>
			</div>
		</div>
	</div>
</div>
