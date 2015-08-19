<?php
//use yii\helpers\Url;

//use frontend\widgets\Regions;
//use frontend\widgets\Currency;

?>



<div class="header__row2">
	<div class="container">
		<div class="row clearfix">
			<div class="col-lg-5">
				<?/*
				<a href="http://team.by" class="logo_top">
					<img class="logo_top__img" src="/images/logo-pro-top.png" alt="Профессионалы">
					<span class="logo_top__cnt">
						<span class="logo_top__sitename">Профессионалы</span>
						<span class="logo_top__slogan">Только проверенные специалисты</span>
					</span>
				</a>
				*/?>
				<a href="<?php echo Yii::$app->params['homeUrl']; ?>" class="logo_top" title="команда профессионалов">
					<img class="logo_top__img" src="/images/logo-pro-top.png" alt="Профессионалы">
				</a>
				
			</div>

			<div class="col-lg-5 col-lg-offset-2">
				<?php echo $this->render('@frontend/views/layouts/_header_phone', [], false, true); ?>
			</div>

		</div>
	</div>
</div>
