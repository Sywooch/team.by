<?php
//use yii\helpers\Url;

//use frontend\widgets\Regions;
//use frontend\widgets\Currency;

?>



<div class="header__row2">
	<div class="container">
		<div class="row clearfix">
			<div class="col-lg-5">
				<a href="http://team.by" class="logo_top">
					<img class="logo_top__img" src="/images/logo-top.png" alt="Профессионалы">
					<span class="logo_top__cnt">
						<span class="logo_top__sitename">Профессионалы</span>
						<span class="logo_top__slogan">Только проверенные специалисты</span>
					</span>
				</a>
			</div>

			<div class="col-lg-5 col-lg-offset-2">
				<?php echo $this->render('@frontend/views/layouts/_header_phone', [], false, true); ?>
			</div>

		</div>
	</div>
</div>
