<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace pro\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class RegStep2Asset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = 'http://team.by';
    public $css = [];
    public $js = [
		//'js/fileuploader.js',
		'js/jquery.ajax.upload.js',
    ];
    public $depends = [
        //'frontend\assets\AppAsset',
		'yii\web\YiiAsset',
    ];
}
