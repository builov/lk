<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAssetLK extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'css/site.css',
//        'fias/jquery.fias.min.css',
        'https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;400;500;600;700&family=Merriweather:wght@700&display=swap',
        'css/libs/bootstrap.min.css',
        'css/libs/animate.css',
        'css/libs/jquery.fancybox.min.css',
        'css/libs/jquery.scrollbar.css',
        'css/libs/jquery.formstyler.css',
        'css/libs/jquery.formstyler.theme.css',
        'css/libs/dropzone.min.css',
        'css/dist/app.css'
    ];
    public $js = [
//        'js/jquery.maskedinput.min.js',
//        'js/script.js',
//        'fias/jquery.fias.min.js',
//        'fias/script.js',
        'js/libs/bootstrap.min.js',
        'js/libs/modernizr.custom.js',
        'js/libs/jquery.fancybox.min.js',
        'js/libs/jquery.scrollbar.min.js',
        'js/libs/jquery.formstyler.js',
        'js/libs/jquery.matchHeight.js',
        'js/libs/jquery.inputmask.js',
        'js/libs/jquery.fias.min.js',
        'js/libs/dropzone.min.js',
        'js/lk.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
