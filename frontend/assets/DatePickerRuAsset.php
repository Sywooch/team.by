<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DatePickerRuAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [
		'js/bootstrap-datepicker.ru.js',
    ];
    public $depends = [
		//'dosamigos\datepicker\DatePicker\DatePickerAsset',
		//'@vendor\2amigos\yii2-date-picker-widget\src\DatePickerAsset',
		'dosamigos\datepicker\DatePickerAsset'
    ];
}
