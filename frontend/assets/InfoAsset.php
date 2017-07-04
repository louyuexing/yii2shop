<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class InfoAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/common.css',
         'style/goods.css',
        'style/bottomnav.css',
        'style/footer.css',
        'style/jqzoom.css',


    ];
    public $js = [
        'js/jquery-1.8.3.min.js',
        'js/header.js',
        'js/goods.js',
        'js/jqzoom-core.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',

    ];
}
