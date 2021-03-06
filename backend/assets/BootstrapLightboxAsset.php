<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BootstrapLightboxAsset extends AssetBundle
{
    public $basePath = '@webroot';
    //public $baseUrl = '@web';
    public $baseUrl = 'http://team.by';
    public $css = [
		'css/ekko-lightbox.min.css',
	];
    public $js = [
		'js/ekko-lightbox.min.js',
		'http://team.by/js/ekko-lightbox-init.js',		
    ];
    public $depends = [
        //'frontend\assets\AppAsset',
		'yii\web\YiiAsset',
    ];
}
