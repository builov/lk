<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\RegisterFormStepOne */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
//use yii\jui\DatePicker;
use common\models\Profile;

//print_r($model);

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="">


    <div class="row">
        <div class="col-lg-8">

            <h2><?= Html::encode($this->title) ?></h2>

            <?php $form = ActiveForm::begin([
                'id' => 'register-form',
                'enableAjaxValidation'   => false,
                'enableClientValidation' => true,
                'validateOnBlur'         => false,
                'validateOnType'         => false,
                'validateOnChange'       => false,
                'validateOnSubmit'       => true,
            ]); ?>

            <fieldset>
                <legend>Личные данные</legend>

                <?= $form->field($model['reg_form'], 'lastname')->textInput(['autofocus' => true, 'value' => 'Фамилия']) ?>

                <?= $form->field($model['reg_form'], 'firstname')->textInput(['value' => 'Имя']) ?>

                <?= $form->field($model['reg_form'], 'patronim')->textInput(['value' => 'Отчество']) ?>

                <?= $form->field($model['reg_form'], 'birthdate')->textInput(['type' => 'date', 'value' => '1111-11-11']) ?>

                <?= $form->field($model['reg_form'], 'snils')->textInput(['value' => '1111111']) ?>

                <?php $model['reg_form']->gender = 1 ?>
                <?= $form->field($model['reg_form'], 'gender')->radioList(Profile::_GENDER); ?>
            </fieldset>

            <fieldset>
                <legend>Образование</legend>

                <?= $form->field($model['reg_form'], 'education_level')->dropDownList(Profile::_EDUCATION) ?>

                <?= $form->field($model['reg_form'], 'institution')->textInput(['value' => 'Школа №1']) ?>

                <?= $form->field($model['reg_form'], 'graduate_year')->textInput(['value' => 2020]) ?>
            </fieldset>

            <fieldset>
                <legend>Паспорт</legend>

                <label class="control-label" for="registerform-passport_series">Серия и номер паспорта</label>

                <?= $form->field($model['reg_form'], 'passport_series')->textInput(['maxlength' => 5, 'value' => '123456', 'class' => 'form-control class1'])->label(false) ?>

                <?= $form->field($model['reg_form'], 'passport_number')->textInput(['maxlength' => 6, 'value' => '123456', 'class' => 'form-control class2'])->label(false) ?>

                <?= $form->field($model['reg_form'], 'passport_issued')->textarea(['rows' => 2, 'cols' => 5, 'value' => 'Отдел УВД №1']) ?>

                <?= $form->field($model['reg_form'], 'passport_code')->textInput(['value' => '123456']) ?>

                <?= $form->field($model['reg_form'], 'passport_date')->textInput(['type' => 'date', 'value' => '1111-11-11']) ?>
            </fieldset>

            <fieldset>
                <legend>Контактные данные</legend>

                <?= $form->field($model['reg_form'], 'region')->dropDownList(Profile::_REGION) ?>

                <?= $form->field($model['reg_form'], 'address_passport')->textarea(['rows' => 2, 'cols' => 5, 'value' => 'Адрес 1']) ?>

                <?= $form->field($model['reg_form'], 'address_current')->textarea(['rows' => 2, 'cols' => 5, 'value' => 'Адрес 2']) ?>

                <?= $form->field($model['reg_form'], 'zip')->textInput(['value' => '123456']) ?>

                <?= $form->field($model['reg_form'], 'phone')->textInput(['value' => '123456']) ?>

                <?= $form->field($model['reg_form'], 'email')->textInput(['value' => 'mail@mail.ru'])->hint('Будьте внимательны, на этот адрес Вам будет отправлен пароль от Личного кабинета абитуриента') ?>
            </fieldset>

            <?= $form->field($model['reg_form'], 'agree')->checkbox([
                'label' => 'Я подтверждаю согласие на обработку моих <a href="">персональных данных</a>',
                'labelOptions' => [
                    'style' => 'visibility:visible;'
                ],
                'disabled' => false,
                'checked' => true
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Дальше', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-lg-4">

            <h2>Вход</h2>

            <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'action' => 'site/login'
            ]); ?>

            <?= $form->field($model['login_form'], 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model['login_form'], 'password')->passwordInput() ?>

            <?= $form->field($model['login_form'], 'rememberMe')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <div style="color:#999;margin:1em 0">
                <?= Html::a('Забыли пароль?', ['site/request-password-reset']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
