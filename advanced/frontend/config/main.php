<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'layout' => 'new2',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'application/saved/<id:\d+>' => 'application/saved',
                'profile/application/<mode>' => 'profile',
                'user/<id:\d+>/messages' => 'transmit/user-messages',
                'message/<id:\d+>/dont-show' => 'profile/dont-show-message',
                'application/<id:\d+>' => 'application/index',
                'delete-scan/<type>' => 'profile/delete-scan',
                'site/request-password-reset/<mode>' => 'site/request-password-reset',
                'delete-file/<id:\d+>' => 'profile/delete-file'
            ],
        ],
    ],
    'params' => $params,
];
