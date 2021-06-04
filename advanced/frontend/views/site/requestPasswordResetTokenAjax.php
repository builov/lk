<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Сброс пароля';
?>



<!--                    <div class="ct__box">-->
<!---->
<!--                        <h2>--><?//= Html::encode($this->title) ?><!--</h2>-->
<!---->
<!--                        <p>Напишите Ваш адрес электронной почты, указанный при регистрации. На него будет отправлена ссылка для сброса пароля.</p>-->
<!---->
<!---->
<!--                        --><?php //$form = ActiveForm::begin(['id' => 'request-password-reset-form', 'validateOnBlur' => false]); ?>
<!---->
<!--                        --><?//= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
<!---->
<!--                        <div class="form-group">-->
<!--                            --><?//= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
<!--                        </div>-->
<!---->
<!--                        --><?php //ActiveForm::end(); ?>
<!---->
<!--                        <a href="/">Регистрация</a>-->
<!---->
<!--                    </div>-->



<div id="recovery-modal" class="modal__custom modal__custom-centered modal__custom-sm">
    <div class="modal__custom-bl">
        <div class="modal__header">
            <div class="modal__title">
                <?= Html::encode($this->title) ?>
            </div>
<!--            <a href="#" class="modal__close modal-close-js">-->
<!--                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">-->
<!--                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.29289 4.29289C4.68342 3.90237 5.31658 3.90237 5.70711 4.29289L12 10.5858L18.2929 4.29289C18.6834 3.90237 19.3166 3.90237 19.7071 4.29289C20.0976 4.68342 20.0976 5.31658 19.7071 5.70711L13.4142 12L19.7071 18.2929C20.0976 18.6834 20.0976 19.3166 19.7071 19.7071C19.3166 20.0976 18.6834 20.0976 18.2929 19.7071L12 13.4142L5.70711 19.7071C5.31658 20.0976 4.68342 20.0976 4.29289 19.7071C3.90237 19.3166 3.90237 18.6834 4.29289 18.2929L10.5858 12L4.29289 5.70711C3.90237 5.31658 3.90237 4.68342 4.29289 4.29289Z" fill="#1F1F1F"/>-->
<!--                </svg>-->
<!--            </a>-->
        </div>
        <div class="modal__custom-content">
            <div class="fade-state fadeIn animated active">
<!--                <form class="form-recovery" method="post" action="">-->
                <?php $form = ActiveForm::begin([
                    'id' => 'request-password-reset-form',
                    'action' => '/site/request-password-reset',
                    'options' => [
                        'class' => 'form-recovery'
                    ],
                ]); ?>
                    <div class="form__group">
                        <div class="form__item">
                            <div class="form__item-label">
                                Ваш адрес электронной почты, указанный при регистрации. На него будет отправлена ссылка для сброса пароля.
                            </div>
                            <div class="form__field">
<!--                                <input type="text">-->
                                <?= $form->field($model, 'email')->textInput(['autofocus' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="form__item">
                            <button type="submit" class="btn__custom btn__custom-full d-flex align-items-center justify-content-center">
                                Отправить
                            </button>
<!--                            --><?//= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </form>
            </div>
<!--            <div id="recovery-result" class="fade-state fadeIn animated">-->
<!--                <div class="label__custom text-center">-->
<!--                    Пароль выслан на почту-->
<!--                </div>-->
<!--                <a href="#" class="btn__border btn__custom-full d-flex align-items-center justify-content-center modal-close-js">-->
<!--                    Понятно-->
<!--                </a>-->
<!--            </div>-->
        </div>
    </div>
</div>

