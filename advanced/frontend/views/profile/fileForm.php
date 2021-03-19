<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

    <img src="/uploads/<?= $model->imageFile->name ?>" />

<?php $form = ActiveForm::begin([
    'id' => 'upload-form',
    'action' => '/profile/upload-file',
    'options' => ['enctype' => 'multipart/form-data'],
]) ?>

<?= $form->field($model, 'imageFile')->fileInput()->label(false) ?>

<?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>

<?php ActiveForm::end() ?>