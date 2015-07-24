<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

class JcarouselAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
		'css/jcarousel.responsive.css',
	];
    public $js = [
		'js/jquery.jcarousel.min.js',
		'js/jcarousel.responsive.js',
    ];
    public $depends = [
		'yii\web\YiiAsset',
    ];
}
