<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RegStep2Form */
/* @var $form ActiveForm */

//echo'<pre>';print_r($categories);echo'</pre>';
?>
<div class="site-reg-step2">
<?/*
<script type="text/javascript">
$(document).ready(function() {
var upload = new AjaxUpload('#userfile', {
		//upload script 
		action: 'upload.php',
		onSubmit : function(file, extension){
		//show loading animation
		$("#loading").show();
		//check file extension
		if (! (extension && /^(jpg|png|jpeg|gif)$/.test(extension))){
       // extension is not allowed
			 $("#loading").hide();
			 $("<span class='error'>Error: Not a valid file extension</span>").appendTo("#file_holder #errormes");
			// cancel upload
       return false;
			} else {
			  // get rid of error
			$('.error').hide();
			}	
			//send the data
			upload.setData({'file': file});
		},
		onComplete : function(file, response){
		//hide the loading animation
		$("#loading").hide();
		//add display:block to success message holder
		$(".success").css("display", "block");
		
//This lower portion gets the error message from upload.php file and appends it to our specifed error message block
		//find the div in the iFrame and append to error message	
		var oBody = $(".iframe").contents().find("div");
		//add the iFrame to the errormes td
		$(oBody).appendTo("#file_holder #errormes");
		
//This is the demo dummy success message, comment this out when using the above code
		//$("#file_holder #errormes").html("<span class='success'>Your file was uploaded successfully</span>");
}
	});
});	
		</script>
</head>

<body>
  <div id="file_holder">
 <form action="upload.php" method="post" enctype="multipart/form-data">
	<h3>Ajax upload demo</h3>
  
  <div></div>
  
<p><label for="userfile">Choose images(s) to upload:</label>
 <input id="userfile" class="input" type="file" name="userfile" />
 </p>
 <div id="loading"><img src="ajax-loader.gif" alt="Loading" /> Loading, please wait...</div>
 <div id="errormes"></div>
  
<noscript><input type="submit" value="submit" class="button2" /></noscript>
</form>
*/?>
	<div class="col-lg-7">  
	<?php $form = ActiveForm::begin([
		'options'=> ['enctype' => 'multipart/form-data' ],
		'enableClientValidation' => false,
		'id'=>'site-reg-step2-frm',
	] ); ?>

		<?= $form->field($model, 'region')->dropDownList($model->regionsDropDownList, [$model->region]) ?>
		
		<div class="form-group">
			<a href="" id="site-reg-add-new-city" class="site-reg__add-new-city">Добавить город</a>
		</div>
		
		
		
		<div id="site-reg-add-new-city-cnt" class="row clearfix site-reg-add-new-city-cnt">
			<div class="col-lg-6">
				<?= $form->field($model, 'region_parent_id')->dropDownList($model->regionsDropDownList, [$model->region]) ?>   
			</div>
			
			<div class="col-lg-6">
				<?= $form->field($model, 'region_name') ?>
			</div>
			
			<?/*
			<div class="col-lg-4">
				<a href="#" id="site-reg-add-new-city-btn" class="button-red">Добавить</a>
			</div>
			*/?>
		</div>
		
		<?= $form->field($model, 'about')->textarea() ?>
		<?= $form->field($model, 'education')->textarea() ?>
		
		
		<?= $form->field($model, 'experience')->textarea() ?>
		
		<?= $form->field($model, 'category1')->dropDownList($model->categoriesLevel1DropDownList, [$model->category1, 'prompt'=>'Например: строительство']) ?>
		
		
		<?php foreach($categories as $cat1)	{	?>
			<div id="category-block-<?= $cat1['id']?>" class="categories-block">
				<p><?php echo $cat1['name']?></p>
				<?php if(count($cat1['children']))	{	?>
						<ul class="row clearix">
						<?php 
							foreach($cat1['children'] as $cat2)	{
								echo Html::tag('li', Html::checkbox('RegStep2Form[category][]', false, ['label' => $cat2['name'], 'value'=>$cat2['id'], 'id'=>'category-'.$cat2['id'], 'class'=>'reg-step2-category']), ['class'=>'col-lg-4'] );	
							}	
						?>
						</ul>
					
				<?php	}	?>
			</div>				
		<?php	}	?>
		
		
		<div id="selected_categories" class="selected_categories form-horizontal solid-border-block">
			<div class="selected_categories_ttl">Выбранные рубрики</div>
			<div id="selected_categories_cnt"></div>
		</div>
		
		
		<?= $form->field($model, 'price_list') ?>
		<?= $form->field($model, 'avatar') ?>

		<div class="form-group">
			<?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
		</div>
	<?php ActiveForm::end(); ?>
	</div>
	<div class="col-lg-5"></div>

</div><!-- site-reg-step2 -->
