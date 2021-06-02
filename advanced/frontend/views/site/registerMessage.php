<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="section sc__lk sides">
    <div class="container">

        <div class="sc__lk-content">
            <div class="row">
                <div id="reg-lk" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 tabs__lk-pane fadeIn animated active">
<!--                    <div class="sc__box-header hidden-md-down">-->
<!--                        <div class="sc__box-title seo__item">-->
<!--                            Регистрация-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="ct__box ct__box-reg">

                        <div class="reg__result reg-state active fadeIn animated">
                            <div class="reg__result-content text-center">
                                <div class="reg__result-icon">
                                    <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22 39C31.3888 39 39 31.3888 39 22C39 12.6112 31.3888 5 22 5C12.6112 5 5 12.6112 5 22C5 31.3888 12.6112 39 22 39Z" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.7071 22.2929L15.2929 21.7071C15.6834 21.3166 16.3166 21.3166 16.7071 21.7071L19.2547 24.2547C19.6598 24.6598 20.3218 24.6424 20.7051 24.2166L28.2949 15.7834C28.6782 15.3576 29.3402 15.3402 29.7453 15.7453L30.323 16.323C30.7015 16.7015 30.7148 17.3111 30.353 17.7058L20.7057 28.2301C20.321 28.6498 19.6641 28.6641 19.2615 28.2615L14.7071 23.7071C14.3166 23.3166 14.3166 22.6834 14.7071 22.2929Z" fill="#B4E3F9" stroke="#145797" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="reg__result-title">
<!--                                    Мы сохранили ваши данные, осталось совсем немного-->
                                    Спасибо, Ваша учетная запись создана.
                                </div>
                                <div class="reg__result-text">
<!--                                    <p>Чтобы войти в Личный кабинет абитуриента, проверьте Ваш почтовый ящик, на который мы выслали код подтверждения и пароль.</p>-->

                                    <p>На указанный Вами email отправлен код подтверждения (без него учетная запись не будет активирована) и пароль для входа в Личный кабинет абитуриента.
                                    <br>Если Вы не видите нашего письма, обязательно проверьте папку Спам.</p>

                                    <a href="/site/resend-verification-email">Отправить код подтверждения еще раз</a> (будет отправлен на тот же email, указанный при регистрации).
                                    <br>Если Вы указали неверный email, придется <a href="/">пройти процедуру регистрации</a> еще раз.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!--                <div id="login-lk" class="col-lg-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 tabs__lk-pane fadeIn animated side-right">-->
<!--                    <div class="sc__box-header hidden-md-down">-->
<!--                        <div class="sc__box-title seo__item">-->
<!--                            Вход-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="ct__box">-->
<!--                        --><?php //$form = ActiveForm::begin([
//                            'id' => 'login-form',
//                            'options' => [
//                                'class' => 'form-login'
//                            ],
//                            'action' => 'site/login',
//                            'enableAjaxValidation'   => false,
//                            'enableClientValidation' => false,
//                            'validateOnBlur'         => false,
//                            'validateOnType'         => false,
//                            'validateOnChange'       => false,
//                            'validateOnSubmit'       => true,
//                        ]); ?>
<!--                        <div class="form__list">-->
<!--                            <div class="form__item">-->
<!--                                <div class="form__item-label">-->
<!--                                    Ваш e-mail-->
<!--                                </div>-->
<!--                                <div class="form__item-field email-field req-field" data-name="d-email">-->
<!--                                    --><?//= $form->field($model['login_form'], 'username', ['options' => ['tag' => false, 'template' => "{input}"]])->textInput(['class' => 'input'])->label(false) ?>
<!--                                    <div class="error__message"></div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="form__item">-->
<!--                                <div class="form__item-label">-->
<!--                                    Пароль-->
<!--                                </div>-->
<!--                                <div class="form__item-field req-field" data-name="d-password">-->
<!--                                    --><?//= $form->field($model['login_form'], 'password', ['options' => ['tag' => false, 'template' => "{input}"]])->passwordInput(['class' => 'input'])->label(false) ?>
<!--                                    <div class="error__message"></div>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                            --><?//= $form->field($model['login_form'], 'rememberMe', ['options' => ['tag' => false, 'template' => "{input}"]])->checkbox() ?>
<!---->
<!--                            <div class="form__item">-->
<!--                                --><?//= Html::submitButton('Войти',
//                                    [
//                                        'class' => 'btn__custom btn__custom-full d-flex align-items-center justify-content-center',
//                                        'name' => 'login-button',
//                                        'disabled' => 'disabled'
//                                    ]) ?>
<!--                            </div>-->
<!--                            <div class="form__item">-->
<!--                                <div class="form__link">-->
<!--                                    <a href="/site/request-password-reset" data-touch="false" data-modal="true" data-fancybox="">-->
<!--                                        Забыли пароль?-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        --><?php //ActiveForm::end(); ?>
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</div>