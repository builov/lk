<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

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

                        <p>Напишите Ваш адрес электронной почты, указанный при регистрации. На него будет отправлена ссылка для сброса пароля.</p>


                        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form', 'validateOnBlur' => false]); ?>

                        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                        <a href="/">Регистрация</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
