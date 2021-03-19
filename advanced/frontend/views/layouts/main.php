<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <style>
        nav.navbar-mk7 {
            background: url('/img/topbackground.png') center;
            background-size: cover;
            border-width: 0;
            min-height: 140px;
        }
        .navbar {
            border-radius: 0;
        }
        @media (min-width: 768px) {
            .navbar {
                border-radius: 0;
            }
        }
        .wrap > .container {
            padding-top: 20px;
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
//        'brandLabel' => Yii::$app->name,
        'brandLabel' => Html::img('/img/MK7_logo.png'),
        'brandUrl' => Yii::$app->homeUrl,
//        'encode' => false,
        'options' => [
//            'class' => 'navbar-inverse navbar-fixed-top',
            'class' => 'navbar-inverse navbar-mk7',
        ],
    ]);
    $menuItems = [];
//    $menuItems = [
//        ['label' => 'Home', 'url' => ['/site/index']],
//        ['label' => 'About', 'url' => ['/site/about']],
//        ['label' => 'Contact', 'url' => ['/site/contact']],
//    ];
//    if (Yii::$app->user->isGuest) {
//        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
//        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
//    } else {
//        $menuItems[] = '<li>'
//            . Html::beginForm(['/site/logout'], 'post')
//            . Html::submitButton(
//                'Logout (' . Yii::$app->user->identity->username . ')',
//                ['class' => 'btn btn-link logout']
//            )
//            . Html::endForm()
//            . '</li>';
//    }
    if (!Yii::$app->user->isGuest)
    {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">

<!--        --><?//= Breadcrumbs::widget([
//            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
//        ]) ?>

        <?= Alert::widget() ?>

        <?= $content ?>

    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>

<script>

    $(function() {
        // Загрузка изображения
        var btnSaveImage = $('#upload-form button'),
            btnDeleteImage = $('#delete-image'),
            inputImage = $('#form-image'),
            image = $("#upload-image"),
            process = $('#process');

        // inputImage.on('change', function () {
        //     btnSaveImage.prop('disabled', false);
        // });

        btnSaveImage.on('click', function (e)
        {
            e.preventDefault();

            var form = $('#upload-form');

            var formData = new FormData(form[0]);

            $.ajax({
                url: form.attr("action"),
                type: form.attr("method"),
                data: formData,
                dataType: 'html',
                processData: false,
                contentType: false,
                cache: false,
                // beforeSend: function () {
                //     process.fadeIn('fast');
                // },
                success: function (data) {
                    form[0].reset();

                    console.log(data);

                    $('#image-container').append(data);

                    // data = JSON.parse(data);
                    // btnSaveImage.prop('disabled', true);
                    // btnDeleteImage.fadeIn();
                    // image.attr('src', data.image);
                    // process.delay(1000).fadeOut();
                },
                error: function () {
                    // process.delay(1000).fadeOut();
                    alert('Error!');
                }
            });

            return false;
        });

        // Удаление изображения
        // btnDeleteImage.on("click", function (e) {
        //     e.preventDefault();
        //     var res = confirm('Вы действительно хотите удалить текущее изображение?');
        //     if (!res) return false;
        //     $.ajax({
        //         url: $(this).attr("href"),
        //         type: $(this).data("method"),
        //         dataType: 'text',
        //         processData: false,
        //         contentType: false,
        //         beforeSend: function () {
        //             process.fadeIn('fast');
        //         },
        //         success: function (data) {
        //             data = JSON.parse(data);
        //             btnSaveImage.prop('disabled', true);
        //             image.attr('src', data.image);
        //             btnDeleteImage.fadeOut();
        //             process.delay(1000).fadeOut();
        //         },
        //         error: function () {
        //             process.delay(1000).fadeOut();
        //             alert('Error!');
        //         }
        //     });
        //     return false;
        // });
    });




    // $(function()
    // {
    //     $('#upload-form').submit(function(e)
    //     {
    //         var $form = $(this);
    //
    //         $.ajax({
    //             method: "POST",
    //             url: "/profile/upload-file",
    //             data: {
    //                 name: "Denis",
    //                 city: "Erebor"
    //             },
    //             success: [
    //                 function (msg)
    //                 { // функции обратного вызова, которые вызываются если AJAX запрос выполнится успешно (если несколько функций, то необходимо помещать их в массив)
    //                     console.log( "first function" );
    //                 },
    //                 function ()
    //                 {
    //                     console.log( "next function" );
    //                 }
    //             ],
    //             statusCode: {
    //                 200: function () { // выполнить функцию если код ответа HTTP 200
    //                     console.log( "Ok" );
    //                 }
    //             }
    //         })
    //
    //         //отмена действия по умолчанию для кнопки submit
    //         e.preventDefault();
    //     });
    // });
</script>

</body>
</html>
<?php $this->endPage() ?>
