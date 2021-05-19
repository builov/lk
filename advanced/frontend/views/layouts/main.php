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

        .img-uploaded {
            width:100px;
            height:80px;
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            display:inline-block;
        }

        .field-registerform-snils2 {
            display:none;
        }
        .field-registerform-passport_series_number {
            display:none;
        }

        img.icon {

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

    $menuItems[] = '<li><a href="tel:+74959152783"><img class="icon" src="/img/telephone.svg" /> +7 495 915-27-83</a></li>';
    $menuItems[] = '<li><a target="_blank" href="mailto:pk@medcollege7.ru"><img class="icon" src="/img/envelope.svg" /> pk@medcollege7.ru</a></li>';

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
        <p class="pull-left">
            МЕДИЦИНСКИЙ КОЛЛЕДЖ № 7
            <!--            --><?//= Html::encode(Yii::$app->name) ?><!-- -->
            &copy; <?= date('Y') ?>
        </p>

        <p class="pull-right">
<!--            --><?//= Yii::powered() ?>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>

<script>

    $(function() {

        console.log($('#editprofileform-citizenship').val());

        //форма редактирования профиля

        if ($('#editprofileform-citizenship').value==1)
        {
            $("#editprofileform-passport_code").mask("999-999");
            $("#editprofileform-snils").mask("999-999-999-99");
            $("#editprofileform-passport_series").mask("99 99");
            $("#editprofileform-passport_number").mask("999999");
        }
        else if (this.value==2)
        {
            $(".field-editprofileform-passport_code").hide();
            $(".field-editprofileform-region").hide();
        }

        $("#editprofileform-phone").mask("+7 (999) 999-99-99");
        $("#editprofileform-graduate_year").mask("9999");
        $("#editprofileform-birthdate").mask("99-99-9999");
        $("#editprofileform-passport_date").mask("99-99-9999");

        $('#editprofileform-citizenship').on('change', function() {
            console.log(this.value);
            if (this.value==1)
            {
                $(".field-editprofileform-passport_code").show();
                $(".field-editprofileform-region").show();
                $("#editprofileform-snils").mask("999-999-999-99");
                $("#editprofileform-passport_series").mask("99 99");
                $("#editprofileform-passport_number").mask("999999");
            }
            else if (this.value==2)
            {
                $(".field-editprofileform-passport_code").hide();
                $(".field-editprofileform-region").hide();
                $("#editprofileform-snils").unmask();
                $("#editprofileform-passport_series").unmask();
                $("#editprofileform-passport_number").unmask();
            }
        });


        //форма регистрации

        $('#registerform-citizenship').on('change', function() {
            console.log(this.value);
            if (this.value==1)
            {
                $("#registerform-snils").mask("999-999-999-99");
                // $(".field-registerform-snils1").show();
                // $(".field-registerform-snils2").hide().find('input').val('');
                $(".field-registerform-passport_code").show();
                $(".field-registerform-region").show();
                // $(".field-registerform-passport_series").show();
                // $(".field-registerform-passport_number").show();
                // $(".field-registerform-passport_series_number").hide().find('input').val('');
                $("#registerform-passport_series").mask("99 99");
                $("#registerform-passport_number").mask("999999");
            }
            else if (this.value==2)
            {
                $("#registerform-snils").unmask();
                // $(".field-registerform-snils2").show();
                // $(".field-registerform-snils1").hide().find('input').val('');
                $(".field-registerform-passport_code").hide();
                $(".field-registerform-region").hide();
                // $(".field-registerform-passport_series").hide().find('input').val('');
                // $(".field-registerform-passport_number").hide().find('input').val('');
                // $(".field-registerform-passport_series_number").show();
                $("#registerform-passport_series").unmask();
                $("#registerform-passport_number").unmask();
            }
        });

        $("#registerform-phone").mask("+7 (999) 999-99-99");
        // $("#registerform-zip").mask("999999");
        $("#registerform-passport_code").mask("999-999");
        $("#registerform-snils").mask("999-999-999-99");
        $("#registerform-graduate_year").mask("9999");
        $("#registerform-passport_series").mask("99 99");
        $("#registerform-passport_number").mask("999999");

        $("#registerform-birthdate").mask("99-99-9999");
        $("#registerform-passport_date").mask("99-99-9999");

        $('#the-same').on('click', function ()
        {
            if ($(this).prop('checked'))
            {
                var street = $('input#registerform-address_passport_street').val(),
                    building = $('input#registerform-address_passport_building').val(),
                    apartment = $('input#registerform-address_passport_apartment').val();

                console.log($(this).prop('checked'));

                $('input#registerform-address_current_street').val(street);
                $('input#registerform-address_current_building').val(building);
                $('input#registerform-address_current_apartment').val(apartment);
            }
            else {
                $('input#registerform-address_current_street').val('');
                $('input#registerform-address_current_building').val('');
                $('input#registerform-address_current_apartment').val('');
            }
        });


        //форма заявки на обучение

        $('button[name="signup-button"]').on('click', function ()
        {
            $("#application-form").submit();
        });

        $('input[type="file"]').on('change', function (e) {
            e.preventDefault();

            // console.log(typeof $(this).val());

            if ($(this).val() != '')
            {
                var form = $(this).parents('form.upload-form'),
                    formData = new FormData(form[0]),
                    imageContainer = form.find('.image-container'),
                    messageContainer = form.find('.xhr-message');

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

                        // console.log(data);

                        imageContainer.append(data);
                        messageContainer.empty();

                        // data = JSON.parse(data);
                        // btnSaveImage.prop('disabled', true);
                        // btnDeleteImage.fadeIn();
                        // image.attr('src', data.image);
                        // process.delay(1000).fadeOut();
                    },
                    error: function (xhr, status, error) {
                        // process.delay(1000).fadeOut();

                        if (error == 'Unsupported Media Type') {
                            // console.log('Неподдерживаемый формат файла или слишком большой размер.');
                            messageContainer.text('Неподдерживаемый формат или слишком большой размер файла.');
                        } else {
                            // console.log('Ошибка загрузки файла: ' + error);
                            // console.log('Ошибка загрузки файла. Возможно, сервер перегружен.');
                            messageContainer.text('Ошибка загрузки файла: ' + error);
                        }
                    }
                });
            }
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
