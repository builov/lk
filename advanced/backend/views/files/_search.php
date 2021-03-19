<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FilesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="files-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'uid') ?>

    <?= $form->field($model, 'path') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'sizex') ?>

    <?php // echo $form->field($model, 'sizey') ?>

    <?php // echo $form->field($model, 'mime') ?>

    <?php // echo $form->field($model, 'weight') ?>

    <?php // echo $form->field($model, 'created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
