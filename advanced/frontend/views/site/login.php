<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="section sc__lk">
    <div class="container">

        <div class="sc__lk-content">
            <div class="row">
                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-xs-5">

                    <div class="ct__box">

                        <h2><?= Html::encode($this->title) ?></h2>


                        <?php $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'enableAjaxValidation'   => false,
                            'enableClientValidation' => true,
                            'validateOnBlur'         => false,
                            'validateOnType'         => false,
                            'validateOnChange'       => false,
                            'validateOnSubmit'       => true,
                        ]); ?>

                        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                        <?= $form->field($model, 'password')->passwordInput() ?>

                        <?= $form->field($model, 'rememberMe')->checkbox() ?>

                        <p>Если у Вас еще нет учетной записи: <a class="btn btn-primary" href="/">зарегистрируйтесь</a>.</p>

                        <div style="color:#999;margin:1em 0">
                            <?= Html::a('Забыли пароль?', ['site/request-password-reset']) ?>
                            <br>
                            Отправить проверочный код на email еще раз: <?= Html::a('Отправить', ['site/resend-verification-email']) ?>
                        </div>

                        <div class="form-group">
                            <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
