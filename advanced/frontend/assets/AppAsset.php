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
//        'css/site.css',
//        'fias/jquery.fias.min.css',
        'https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;400;500;600;700&family=Merriweather:wght@700&display=swap',
        'css/new/libs/bootstrap.min.css',
        'css/new/libs/animate.css',
        'css/new/libs/jquery.fancybox.min.css',
        'css/new/libs/jquery.scrollbar.css',
        'css/new/libs/jquery.formstyler.css',
        'css/new/libs/jquery.formstyler.theme.css',
        'css/new/libs/slick.min.css',
        'css/new/dist/app.css'
    ];
    public $js = [
//        'js/jquery.maskedinput.min.js',
//        'js/script.js',
//        'fias/jquery.fias.min.js',
//        'fias/script.js',
        'js/new/libs/modernizr.custom.js',
        'js/new/libs/jquery.fancybox.min.js',
        'js/new/libs/jquery.scrollbar.min.js',
        'js/new/libs/jquery.formstyler.js',
        'js/new/libs/jquery.matchHeight.js',
        'js/new/libs/jquery.inputmask.js',
        'js/new/libs/jquery.fias.min.js',
        'js/new/lk3.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
