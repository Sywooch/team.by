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
class DocumentsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = 'https://pro.team.by';
    public $css = [];
    public $js = [
		'js/jquery.ajax.upload.js',
		//'js/site-reg.js',
		'js/documents.js',
    ];
    public $depends = [
		'yii\web\YiiAsset',
    ];
}
