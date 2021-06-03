<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Сброс пароля';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="section sc__lk">
    <div class="container">

        <div class="sc__lk-content">
            <div class="row">
                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-xs-5">

                    <div class="ct__box">

                        <h2><?= Html::encode($this->title) ?></h2>

                        <p>Укажите новый пароль:</p>


                        <?php $form = ActiveForm::begin(['id' => 'reset-password-form',
                            'enableAjaxValidation'   => false,
                            'enableClientValidation' => true,
                            'validateOnBlur'         => false,
                            'validateOnType'         => false,
                            'validateOnChange'       => false,
                            'validateOnSubmit'       => true]); ?>

                        <?= $form->field($model, 'password')->passwordInput(['autofocus' => true])->label(false) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


