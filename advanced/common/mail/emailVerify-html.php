<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
<div class="verify-email">
    <p>Здравствуйте, <?= Html::encode($user->fio) ?>,</p>

    <p>Ваш логин для входа в личный кабинет абитуриента: <?= Html::encode($user->email) ?></p>

    <p>Ваш пароль: <?= Html::encode($user->password_raw) ?></p>

    <p>Для завершения регистрации Вам необходимо перейти по следующей ссылке (или скопировать её в адресную строку браузера):</p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
