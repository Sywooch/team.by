<?php
/**
 * Created by PhpStorm.
 * User: adegtyarev
 * Date: 24.03.2016
 * Time: 15:06
 */

use yii\helpers\Html;

$model_name = 'RegStep2Form';
?>


<?php foreach($categories as $cat1)	{	?>
    <div id="category-block-<?= $cat1['id']?>" class="categories-block">
        <p><?php echo $cat1['name']?></p>
        <?php if(count($cat1['children']))	{	?>
            <?php $col1 = $col2 = '';?>

            <?php

            foreach($cat1['children'] as $i=>$cat2)	{
                $inner_li = Html::checkbox(
                    $model_name.'[categories][]',
                    '',
                    [
                        'label' => $cat2['name'],
                        'labelOptions'=> [
                            'class'=> '',
                        ],
                        'value'=>$cat2['id'],
                        'id'=>'category-'.$cat2['id'],
                        'class'=>'reg-step2-category',
                    ]
                );


                if(isset($categories_l3[$cat2['id']]))	{
                    $inner_li .= '<ul id="cnt-price-'.$cat2['id'].'" style="display:none;">';
                    foreach($categories_l3[$cat2['id']] as $child_k => $child)	{
                        $cl = 'col-sm-5';

                        $inner_li .= '<li id="usluga-price-'.$child_k.'" class="form-group clearfix">';
                        $inner_li .= '<div class="'.$cl.' categories-block-lbl-cnt">';
                        $inner_li .= Html::checkbox(
                            $model_name.'[usluga][]',
                            '',
                            [
                                'label' => $child,
                                'labelOptions'=> [
                                    'class'=> 'control-label',
                                ],

                                'value'=>$child_k,
                                'id'=>'usluga-'.$child_k
                            ]
                        );
                        $inner_li .= '</div>';
                        $inner_li .= '<div class="col-sm-3">';
                        $inner_li .=  Html::textInput( $model_name.'[price]['.$child_k.']', '', ['class'=>"form-control price-input", 'id'=>'price-'.$child_k, 'placeholder'=>'Стоимость'] );
                        $inner_li .= '</div>';

                        $inner_li .= '<div class="col-sm-2 profile-uslugi-currency">';
                        $inner_li .= ' бел.руб';

                        $inner_li .= '<span class="profile-unit-ttl">за<span>';

                        $inner_li .= '</div>';

                        $inner_li .= '<div class="col-sm-2">';
                        $inner_li .=  Html::textInput( $model_name.'[unit]['.$child_k.']', '', ['class'=>"form-control", 'id'=>'price-'.$child_k, 'placeholder'=>'за'] );
                        $inner_li .= '</div>';

                        $inner_li .= '</li>';
                    }
                    $inner_li .= '</ul>';
                }
                $elem = Html::tag('li', $inner_li/*, ['class'=>'col-lg-611']*/ );
                $col1 .= $elem;
            }
            ?>
            <ul><?= $col1 ?></ul>
        <?php	}	?>
    </div>
<?php	}	?>

