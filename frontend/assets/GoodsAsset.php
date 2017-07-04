<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class GoodsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/common.css',
         'style/list.css',
        'style/bottomnav.css',
        'style/footer.css',
        'style/cart.css',
        'style/fillin.css',




    ];
    public $js = [
        'js/jquery-1.8.3.min.js',
        'js/header.js',
        'js/list.js',
         'js/cart1.js',
        'js/cart2.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
