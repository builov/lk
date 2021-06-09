<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */


?>
<div class="message">
    <p><?= Html::encode($name); ?>!</p>

    <p>К сожалению, Вы не представили оригиналы документов на поступление в ГБПОУ ДЗМ МЕДИЦИНСКИЙ КОЛЛЕДЖ №7 по профессии/специальности <?= $data['course'] ?> в установленные сроки,
        в связи с чем мы вынуждены аннулировать Ваше заявление.</p>

</div>
