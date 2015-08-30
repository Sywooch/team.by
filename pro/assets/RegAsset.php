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
class RegAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = 'https://team.by';
    public $css = [];
    public $js = [
		'js/site-reg.js',
    ];
    public $depends = [
		'yii\web\YiiAsset',
    ];
}
