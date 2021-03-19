<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\RegisterFormStepOne */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

//print_r($model);

$this->title = 'Личные данные';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin([
                    'id' => 'register-step-1',
                    'enableAjaxValidation'   => false,
                    'enableClientValidation' => false,
                    'validateOnBlur'         => false,
                    'validateOnType'         => false,
                    'validateOnChange'       => false,
                    'validateOnSubmit'       => true,
            ]); ?>

            <?= $form->field($model, 'lastname')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'firstname') ?>

            <?= $form->field($model, 'patronim') ?>

            <?= $form->field($model, 'birthdate') ?>

            <?= $form->field($model, 'snils') ?>

            <?= $form->field($model, 'gender')->radioList([
                '1' => 'Женский',
                '2' => 'Мужской'
            ]); ?>

            <div class="form-group">
                <?= Html::submitButton('Дальше', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
