<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
//Follow the link below to reset your password:
?>
Здравствуйте, <?= $user->username ?>,

Для смены пароля перейдите по ссылке (или скопируйте текст ссылки в адресную строку браузера):

<?= $resetLink ?>
