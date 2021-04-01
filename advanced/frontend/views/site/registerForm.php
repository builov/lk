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



<!--            <input name="address" type="text" value="" placeholder="Адрес">-->



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

                <?= $form->field($model['reg_form'], 'lastname')->textInput(['autofocus' => true, 'value' => '']) ?>

                <?= $form->field($model['reg_form'], 'firstname')->textInput() ?>

                <?= $form->field($model['reg_form'], 'patronim')->textInput() ?>

                <?= $form->field($model['reg_form'], 'birthdate')->textInput(['type' => 'date']) ?>

                <?= $form->field($model['reg_form'], 'snils')->textInput() ?>

                <?php $model['reg_form']->gender = 1 ?>
                <?= $form->field($model['reg_form'], 'gender')->radioList(Profile::_GENDER); ?>
            </fieldset>

            <fieldset>
                <legend>Образование</legend>

                <?= $form->field($model['reg_form'], 'education_level')->dropDownList(Profile::_EDUCATION) ?>

                <?= $form->field($model['reg_form'], 'institution')->textInput() ?>

                <?= $form->field($model['reg_form'], 'graduate_year')->textInput() ?>
            </fieldset>

            <fieldset>
                <legend>Паспорт</legend>

                <label class="control-label" for="registerform-passport_series">Серия и номер паспорта</label>

                <?= $form->field($model['reg_form'], 'passport_series')->textInput(['maxlength' => 5, 'class' => 'form-control class1'])->label(false) ?>

                <?= $form->field($model['reg_form'], 'passport_number')->textInput(['maxlength' => 6, 'class' => 'form-control class2'])->label(false) ?>

                <?= $form->field($model['reg_form'], 'passport_issued')->textarea(['rows' => 2, 'cols' => 5, 'value' => '']) ?>

                <?= $form->field($model['reg_form'], 'passport_code')->textInput() ?>

                <?= $form->field($model['reg_form'], 'passport_date')->textInput(['type' => 'date']) ?>
            </fieldset>

            <fieldset>
                <legend>Контактные данные</legend>

                <?= $form->field($model['reg_form'], 'region')->dropDownList(Profile::_REGION)->hint('Для граждан РФ - по паспорту или фактический?') ?>

<!--                --><?//= $form->field($model['reg_form'], 'address_passport')->textarea(['rows' => 2, 'cols' => 5, 'value' => 'Адрес 1']) ?>
<!---->
<!--                --><?//= $form->field($model['reg_form'], 'address_current')->textarea(['rows' => 2, 'cols' => 5, 'value' => 'Адрес 2']) ?>

                <fieldset>
                    <legend>Адрес (как в паспорте)</legend>
<!--                    --><?//= $form->field($model['reg_form'], 'address_passport_region')->textInput() ?>
<!--                    --><?//= $form->field($model['reg_form'], 'address_passport_city')->textInput() ?>
                    <?= $form->field($model['reg_form'], 'address_passport_street')->textInput()
                        ->hint('Если автозаполнение не работает, используйте формат: Регион, (обл. Область,) г. Город, ул. Улица')
                    //                        ->hint('Сначала укажите улицу, для уточнения укажите город, при необходимости район, регион.<br>
//                               Если автозаполнение не работает, используйте формат: Регион, (обл. Область,) г. Город, ул. Улица')
                    ?>
                    <?= $form->field($model['reg_form'], 'address_passport_building')->textInput()->hint('Без слова "дом"') ?>
                    <?= $form->field($model['reg_form'], 'address_passport_apartment')->textInput()->hint('Без слова "квартира"') ?>

                    <legend>Фактический адрес проживания</legend>

                    <div class="checkbox">
                        <label for="the-same">
                            <input type="checkbox" id="the-same" name="the-same">
                            Совпадает с адресом по паспорту.
                        </label>
                    </div>

<!--                    --><?//= $form->field($model['reg_form'], 'address_current_region')->textInput() ?>
<!--                    --><?//= $form->field($model['reg_form'], 'address_current_city')->textInput() ?>
                    <?= $form->field($model['reg_form'], 'address_current_street')->textInput() ?>
                    <?= $form->field($model['reg_form'], 'address_current_building')->textInput() ?>
                    <?= $form->field($model['reg_form'], 'address_current_apartment')->textInput() ?>
                </fieldset>


                <?= $form->field($model['reg_form'], 'zip')->textInput() ?>

                <?= $form->field($model['reg_form'], 'phone')->textInput() ?>

                <?= $form->field($model['reg_form'], 'email')->textInput()
                    ->hint('Будьте внимательны, на этот адрес Вам будет отправлен пароль от Личного кабинета абитуриента') ?>
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

            <?= $form->field($model['login_form'], 'username')->textInput() ?>

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
