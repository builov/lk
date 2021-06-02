<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="">



    <div class="row">
        <div class="col-lg-12">
            <h3>Мы сохранили Ваши данные, осталось совсем немного</h3>

            <p>Чтобы войти в Личный кабинет абитуриента, проверьте Ваш почтовый ящик, на который мы выслали код подтверждения и пароль.</p>

            <a href="/site/resend-verification-email">Отправить код подтверждения еще раз</a> (будет отправлен на тот же email, указанный при регистрации).


        </div>
        <!--div class="col-lg-4">

            <h2>Вход</h2>

            <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'action' => 'site/login'
        ]); ?>

            <?= $form->field($model, 'username')->textInput() ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <div style="color:#999;margin:1em 0">
                <?= Html::a('Забыли пароль?', ['site/request-password-reset']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div-->
    </div>
</div>
