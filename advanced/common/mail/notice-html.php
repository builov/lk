<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */


?>
<div class="message">
    <p>Здравствуйте, <?= Html::encode($name); ?>, </p>

    <p><?= Html::encode($message_text) ?></p>

</div>
