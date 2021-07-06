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

        <?php foreach ($messages as $message): ?>

        <?php $form_id = 'email-message-' . $message['id']; ?>

            <?php $form = ActiveForm::begin(['id' => $form_id]); ?>

            <div class="row">
                <div class="col-lg-3">

<!--                    ->hiddenInput(['value' => 'value']);-->

                    <?= $form->field($form_model, 'message_id')->textInput(['value' => $message['id']]) ?>

                    <?= $form->field($form_model, 'uid')->textInput(['value' => $message['uid']]) ?>

                    <?= $form->field($form_model, 'message_code')->textInput(['value' => $message['code']]) ?>
                </div>

                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary">Отправить</button>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        <hr>

        <?php endforeach; ?>





    </div>
</div>
