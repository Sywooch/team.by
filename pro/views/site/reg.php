<?php
use yii\helpers\Url;

\frontend\assets\FormStylerAsset::register($this);

$this->title = \Yii::$app->params['sitename'] .' | ' . 'Стать специалистом';

//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reg">
    <?/*<h1><?= Html::encode($this->title) ?></h1>*/?>

	<p class="dashed-border-block">Команда профессионалов  — это профильный сервис по подбору специалистов во всех городах Беларуси. У нас зарегистрированы репетиторы, строители,  мастера красоты, врачи, спортивные тренеры, автоинструкторы, артисты, фотографы и другие профессионалы. Присоединяйтесь!»</p>
   
    <div class="row">
        <div class="col-lg-6 site-reg-left">
        	<ul class="site_reg__promo_list">
        		<li class="site_reg__promo_item_1"><span>Хотите рассказать о своих услугах?</span></li>
        		<li class="site_reg__promo_item_2"><span>Надоело платить за неэффективную рекламу?</span></li>
        		<li class="site_reg__promo_item_3"><span>Зарегистрируйтесь у нас и оплачивайте только подтвержденные заказы.</span></li>
        	</ul>
        	
        	<p class="site_reg__rules">
        		<input type="checkbox" id="rules_agree"> С <a href="<?= Url::toRoute(['/page/view', 'alias'=>'pravila-publichnoj-oferty'])?>" target="_blank">правилами публичной оферты</a> ознакомлен и согласен.
        	</p>
        	
			<div id="confirm_agree__popup" class="confirm_agree__popup popup_block">
				Необходимо подтвердить факт ознакомления c условиями Публичной оферты. Для подтверждения поставьте галочку, пожалуйста.
			</div>

        	        	
        	<p class="site_reg__btn_cnt">
        		<a href="<?= Url::toRoute('/site/reg-step1')?>" id="begin-reg" class="button-red">Начать регистрацию</a>
        	</p>
        	
        	
        	
        	
        </div>
        <div class="col-lg-6 site-reg-right">
        	<p class="bold">Регистрация и реклама ваших услуг  абсолютно бесплатны.</p>
        	<ul>
        		<li>Не тратьте время на ненужные звонки – мы подберем вам именно тех клиентов, которые действительно хотят сделать заказ.</li>
        		<li>Не надо сидеть без работы! Новые заказы 365 дней в году.</li>
        		<li>Регистрация займет пару минут, и будет приносить вам доход годами.</li>
        		<li>Рекламу ваших услуг увидят тысячи потенциальных клиентов.</li>
        	</ul>
        </div>
    </div>
</div>
