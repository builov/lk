<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
<div class="verify-email">
    <p>Здравствуйте, <?php if ($user->fio): ?> <?= Html::encode($user->fio); ?>, <?php endif; ?></p>

    <p>Для завершения регистрации Вам необходимо перейти по следующей ссылке (или скопировать её в адресную строку браузера):</p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>

    <p>Ваш логин для входа в личный кабинет абитуриента: <?= Html::encode($user->email) ?></p>

    <?php if ($user->password_raw): ?>
        <p>Ваш пароль: <?= Html::encode($user->password_raw) ?></p>
    <?php else: ?>
        <p>Пароль Вы найдете в первом верификационном письме. Или Вы можете воспользоваться функцией сброса пароля (ссылка "Забыли пароль?" под формой входа).</p>
    <?php endif; ?>

    <p><b>Обратите внимание! До завершения регистрации логин и пароль недействительны.</b></p>

</div>
