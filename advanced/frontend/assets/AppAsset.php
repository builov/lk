<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'fias/jquery.fias.min.css',
    ];
    public $js = [
        'js/jquery.maskedinput.min.js',
        'js/script.js',
        'fias/jquery.fias.min.js',
        'fias/script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
