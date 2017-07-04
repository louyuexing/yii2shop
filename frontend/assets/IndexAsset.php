<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class IndexAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/footer.css',
        'style/index.css',
        'style/bottomnav.css',

    ];

//	<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
//	<script type="text/javascript" src="js/header.js"></script>
//	<script type="text/javascript" src="js/index.js"></script>

    public $js = [
        'js/jquery-1.8.3.min.js',
        'js/header.js',
        'js/index.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
