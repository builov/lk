<?php

/* @var $this yii\web\View */

use yii\widgets\ActiveForm;

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="body-content">

<!--        <pre>-->
<!--             --><?php //print_r($messages); ?>
<!--        </pre>-->

        <?php $i=1; foreach ($messages as $message): ?>

        <?php $form_id = 'email-message-' . $message['id']; ?>

            <?php $form = ActiveForm::begin(['id' => $form_id]); ?>

<!--                    ->hiddenInput(['value' => 'value']);-->

            <div class="row">
                <div class="col-lg-1">
                    <?= $i ?>.
                </div>
                <div class="col-lg-2">
                    <?= $form->field($form_model, 'message_id')->textInput(['value' => $message['id']]) ?>
                </div>
                <div class="col-lg-2">
                    <?= $form->field($form_model, 'uid')->textInput(['value' => $message['uid']]) ?>
                </div>
                <div class="col-lg-2">
                    <?= $form->field($form_model, 'message_code')->textInput(['value' => $message['code']]) ?>
                </div>
                <div class="col-lg-2">
                    <label>Created</label>
                    <p><?= date("d.m.Y H:i", $message['created']) ?></p>
                </div>
                <?php if ($message['date']): ?>
                <div class="col-lg-2">
                    <label>Дата</label>
                    <p><?= date("d.m.Y H:i", $message['date']) ?></p>
                </div>
                <?php endif; ?>
                <div class="col-lg-1">
                    <button type="submit" class="btn btn-primary">Отправить</button>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        <hr>

        <?php $i++; ?>

        <?php endforeach; ?>





    </div>
</div>
