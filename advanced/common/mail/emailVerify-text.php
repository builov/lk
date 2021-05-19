<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
//Follow the link below to verify your email:
?>
Здравствуйте, <?php if ($user->fio): ?> <?= $user->fio; ?>, <?php endif; ?>

Для завершения регистрации Вам необходимо перейти по следующей ссылке (или скопировать её в адресную строку браузера):

<?= $verifyLink ?>

Ваш логин для входа в личный кабинет абитуриента: <?= $user->email ?>.
<?php if ($user->password_raw): ?>
    Ваш пароль: <?= $user->password_raw ?>
<?php else: ?>
    Пароль Вы найдете в первом верификационном письме. Или Вы можете воспользоваться функцией сброса пароля (ссылка "Забыли пароль?" под формой входа).
<?php endif; ?>
Обратите внимание! До завершения регистрации логин и пароль недействительны.

