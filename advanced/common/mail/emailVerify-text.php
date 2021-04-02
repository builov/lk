<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
//Follow the link below to verify your email:
?>
Здравствуйте, <?= $user->username ?>,

Ваш логин для входа в личный кабинет абитуриента: <?= Html::encode($user->email) ?>.

Ваш пароль: <?= Html::encode($user->password_raw) ?>

Для завершения регистрации Вам необходимо перейти по следующей ссылке (или скопировать её в адресную строку браузера):

<?= $verifyLink ?>
