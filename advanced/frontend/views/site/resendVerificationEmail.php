<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Отправить код подтверждения еще раз';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="section sc__lk">
    <div class="container">

        <div class="sc__lk-content">
            <div class="row">
                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-xs-5">

                    <div class="ct__box">

                        <h2><?= Html::encode($this->title) ?></h2>

                        <p>Укажите Ваш адрес электронной почты. На нее будет отправлен код подтверждения.</p>


                        <?php $form = ActiveForm::begin(['id' => 'resend-verification-email-form', 'validateOnBlur' => false]); ?>

                        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                        <a href="/site/request-password-reset">Забыли пароль?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
