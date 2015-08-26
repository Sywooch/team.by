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
class BootstrapLightboxAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
		'https://team.by/css/ekko-lightbox.min.css',
	];
    public $js = [
		//'js/fileuploader.js',
		'https://team.by/js/ekko-lightbox.min.js',
    ];
    public $depends = [
        //'frontend\assets\AppAsset',
		'yii\web\YiiAsset',
    ];
}
