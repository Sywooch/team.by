<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace pro\assets;

use yii\web\AssetBundle;

class FormStylerAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = 'https://pro.team.by';
    public $css = [
		'css/formstyler.css',
	];
    public $js = [
		'js/jquery.formstyler.min.js',
		'js/formstyler-init.js',
    ];
    public $depends = [
		'yii\web\YiiAsset',
    ];
}
