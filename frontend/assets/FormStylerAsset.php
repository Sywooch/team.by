<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

class FormStylerAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
		'https://team.by/css/formstyler.css',
	];
    public $js = [
		'https://team.by/js/jquery.formstyler.min.js',
		'https://team.by/js/formstyler-init.js',
    ];
    public $depends = [
		'yii\web\YiiAsset',
    ];
}
