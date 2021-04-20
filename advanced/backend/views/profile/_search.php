<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProfileSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'uid') ?>

    <?= $form->field($model, 'lastname') ?>

    <?= $form->field($model, 'firstname') ?>

    <?= $form->field($model, 'patronim') ?>

    <?= $form->field($model, 'birthdate') ?>

    <?php // echo $form->field($model, 'snils') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'education_level') ?>

    <?php // echo $form->field($model, 'institution') ?>

    <?php // echo $form->field($model, 'graduate_year') ?>

    <?php // echo $form->field($model, 'passport_series') ?>

    <?php // echo $form->field($model, 'passport_number') ?>

    <?php // echo $form->field($model, 'passport_issued') ?>

    <?php // echo $form->field($model, 'passport_code') ?>

    <?php // echo $form->field($model, 'passport_date') ?>

    <?php // echo $form->field($model, 'region') ?>

    <?php // echo $form->field($model, 'address_passport') ?>

    <?php // echo $form->field($model, 'address_current') ?>

    <?php // echo $form->field($model, 'zip') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'agree') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'updated') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'certificate_series') ?>

    <?php // echo $form->field($model, 'certificate_number') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
