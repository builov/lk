<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\RegisterForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
//use yii\jui\DatePicker;
use common\models\Profile;

//print_r($model);

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>


    <div class="section sc__lk sides">
    <div class="container">
        <div class="tabs__lk-switch d-flex hidden-md-up">
            <div class="tabs__lk-toggle active">
                <a href="#reg-lk" class="sc__box-title">
                    Регистрация
                </a>
            </div>
            <div class="tabs__lk-toggle">
                <a href="#login-lk" class="sc__box-title">
                    Вход
                </a>
            </div>
        </div>
        <div class="sc__lk-content">
            <div class="row">
                <div id="reg-lk" class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12 tabs__lk-pane fadeIn animated active">
                    <div class="sc__box-header hidden-md-down">
                        <div class="sc__box-title seo__item">
                            <?= Html::encode($this->title) ?>
                        </div>
                    </div>
                    <div class="ct__box ct__box-reg">
<!--                        <form method="post" class="form-reg reg-state fadeIn animated active" autocomplete="off" action="">-->
                        <?php $form = ActiveForm::begin([
                                'id' => 'register-form',
//                                'action' => 'site/login',
                                'options' => [
                                    'class' => 'form-reg reg-state fadeIn animated active',
                                    'autocomplete' => 'off'
                                ],
                                'enableAjaxValidation'   => false,
                                'enableClientValidation' => false,
                                'validateOnBlur'         => false,
                                'validateOnType'         => false,
                                'validateOnChange'       => false,
                                'validateOnSubmit'       => true,
                            ]); ?>
                            <div class="ct__progress ct__box-bl">
                                <div class="ct__progress-wrap">
                                    <div class="ct__progress-steps hidden-sm-up">
                                        Шаг <span>1</span> из 4
                                    </div>
                                    <div class="ct__progress-list d-flex align-items-start justify-content-between">
                                        <div class="ct__progress-item active">
                                            <div class="ct__progress-item-title">
                                                Личные данные
                                            </div>
                                        </div>
                                        <div class="ct__progress-item">
                                            <div class="ct__progress-item-title">
                                                Образование
                                            </div>
                                        </div>
                                        <div class="ct__progress-item">
                                            <div class="ct__progress-item-title">
                                                Паспорт
                                            </div>
                                        </div>
                                        <div class="ct__progress-item">
                                            <div class="ct__progress-item-title">
                                                Контактные данные
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ct__progress-bar"><span></span></div>
                                </div>
                            </div>



                            <div class="ct__box-bl">
                                <div class="form__steps">

                                    <div data-step="1" class="form__step fadeIn animated active">

                                        <div class="form__step-title">
                                            Личные данные
                                        </div>
                                        <div class="form__group">

                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Фамилия
                                                </div>
                                                <div class="form__field req-field" data-name="d-surname">
                                                    <?= $form->field($model['reg_form'], 'lastname', ['options' => ['tag' => false, 'template' => "{input}"]])
                                                        ->textInput(['class' => 'input'])->label(false) ?>
<!--                                                    ->textInput(['autofocus' => true])-->
                                                    <div class="error__message fadeIn animated"></div>
                                                </div>
                                            </div>

                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Имя
                                                </div>
                                                <div class="form__field req-field" data-name="d-name">
                                                    <?= $form->field($model['reg_form'], 'firstname', ['options' => ['tag' => false, 'template' => "{input}"]])
                                                        ->textInput(['class' => 'input'])->label(false) ?>
                                                    <div class="error__message fadeIn animated"></div>
                                                </div>
                                            </div>

                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Отчество
                                                </div>
                                                <div class="form__field">
                                                    <?= $form->field($model['reg_form'], 'patronim', ['options' => ['tag' => false, 'template' => "{input}"]])
                                                        ->textInput(['class' => 'input'])->label(false) ?>
                                                </div>
                                            </div>

                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Гражданство
                                                </div>
                                                <div class="select-wrap" data-name="d-nationality">
                                                    <?= $form->field($model['reg_form'], 'citizenship', ['options' => ['tag' => false, 'template' => "{input}"],
                                                                                                                'inputOptions' => ['class' => 'select'],
                                                                                                                'labelOptions' => []])
                                                        ->dropDownList(Profile::_CITIZENSHIP)->label(false) ?>
                                                </div>
                                            </div>

                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Дата рождения
                                                </div>
                                                <div class="form__field form__field-small date-field req-field" data-name="d-birthday">
                                                    <?= $form->field($model['reg_form'], 'birthdate', ['options' => ['tag' => false, 'template' => "{input}"]])
                                                        ->textInput(['class' => 'input'])->label(false) ?>
                                                    <i class="icon__calendar show-calendat-js">
                                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2 14H14V5H2V14ZM15 3H13V1C13 0.448 12.552 0 12 0C11.448 0 11 0.448 11 1V3H5V1C5 0.448 4.552 0 4 0C3.448 0 3 0.448 3 1V3H1C0.448 3 0 3.448 0 4V15C0 15.552 0.448 16 1 16H15C15.552 16 16 15.552 16 15V4C16 3.448 15.552 3 15 3ZM4 9H6V7H4V9ZM7 9H9V7H7V9ZM10 9H12V7H10V9ZM4 12H6V10H4V12ZM7 12H9V10H7V12ZM10 12H12V10H10V12Z" fill="#1F1F1F"/>
                                                        </svg>
                                                    </i>
                                                    <div class="error__message fadeIn animated"></div>
                                                </div>
                                            </div>

                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    СНИЛС
                                                </div>
                                                <div class="form__field form__field-small snils-field req-field" data-name="d-snils">
                                                    <?= $form->field($model['reg_form'], 'snils', ['options' => ['tag' => false, 'template' => "{input}"]])
                                                        ->textInput(['class' => 'input'])->label(false) ?>
                                                    <div class="error__message fadeIn animated"></div>
                                                </div>
                                            </div>

                                            <div class="form__item form__item-horizontal gender-field">
                                                <div class="form__item-label">
                                                    Пол
                                                </div>
                                                <div class="btn__group btn__group-radio d-flex">

                                                    <?= $form->field($model['reg_form'], 'gender', ['options' => ['tag' => false]])
                                                        ->inline(true)
                                                        ->radioList(
                                                                Profile::_GENDER,
                                                            [
                                                                'class' => 'd-flex',
                                                                'item' => function($index, $label, $name, $checked, $value) {

                                                                    $return = "\n\n".'<div class="btn__group-item">
    <label>'
    . "\n".'       <input type="radio" name="' . $name . '" value="' . $value . '">'
    . "\n".'           <div class="btn__radio d-flex align-items-center">'
    . "\n". '               ' . ucwords($label)
    . "\n". '          </div>'
    . "\n". '    </label>
</div>' . "\n\n";

                                                                    return $return;
                                                                }
                                                            ]
                                                        )
                                                        ->label(false); ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div data-step="2" class="form__step fadeIn animated">
                                        <div class="form__step-title">
                                            Образование
                                        </div>
                                        <div class="form__group">
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Уровень образования
                                                </div>
                                                <div class="select-wrap">
                                                    <?= $form->field($model['reg_form'], 'education_level', ['options' => ['tag' => false, 'template' => "{input}"],
                                                        'inputOptions' => ['class' => 'select'],
                                                        'labelOptions' => []])
                                                        ->dropDownList(Profile::_EDUCATION)->label(false) ?>
                                                </div>
                                            </div>
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Название учебного заведения
                                                </div>
                                                <div class="form__field req-field" data-name="d-inst">
                                                    <?= $form->field($model['reg_form'], 'institution', ['options' => ['tag' => false, 'template' => "{input}"]])
                                                        ->textInput(['class' => 'input'])->label(false) ?>
                                                    <div class="error__message fadeIn animated"></div>
                                                    <div class="form__item-hint">
                                                        Например: Школа №678
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Год окончания
                                                </div>
                                                <div class="form__field form__field-small date-field date-field-years req-field" data-name="d-inst-year">
                                                    <?= $form->field($model['reg_form'], 'graduate_year', ['options' => ['tag' => false, 'template' => "{input}"]])
                                                        ->textInput(['class' => 'input', 'maxlength' => 4])->label(false) ?>
                                                    <i class="icon__calendar show-calendat-js">
                                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2 14H14V5H2V14ZM15 3H13V1C13 0.448 12.552 0 12 0C11.448 0 11 0.448 11 1V3H5V1C5 0.448 4.552 0 4 0C3.448 0 3 0.448 3 1V3H1C0.448 3 0 3.448 0 4V15C0 15.552 0.448 16 1 16H15C15.552 16 16 15.552 16 15V4C16 3.448 15.552 3 15 3ZM4 9H6V7H4V9ZM7 9H9V7H7V9ZM10 9H12V7H10V9ZM4 12H6V10H4V12ZM7 12H9V10H7V12ZM10 12H12V10H10V12Z" fill="#1F1F1F"/>
                                                        </svg>
                                                    </i>
                                                    <div class="error__message fadeIn animated"></div>
                                                </div>
                                            </div>
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Серия и номер документа об&nbsp;образовании
                                                </div>
                                                <div class="form__field form__field-small req-field" data-name="d-inst-doc">
                                                    <?= $form->field($model['reg_form'], 'certificate_series', ['options' => ['tag' => false, 'template' => "{input}"]])
                                                        ->textInput(['class' => 'input'])->label(false) ?>
                                                    <?= $form->field($model['reg_form'], 'certificate_number', ['options' => ['tag' => false, 'template' => "{input}"]])
                                                        ->textInput(['class' => 'input'])->label(false) ?>
                                                    <div class="error__message fadeIn animated"></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div data-step="3" class="form__step fadeIn animated">

                                        <div class="form__step-title">
                                            Паспорт
                                        </div>
                                        <div class="form__group">
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Серия, номер
                                                </div>
                                                <div class="form__fields">
                                                    <div class="row">
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 form__field-col">
                                                            <div class="form__field req-field numb-only-field" data-numb-length="4" data-name="d-passport-serial">
<!--                                                                <input type="text" class="input" placeholder="Серия">-->
                                                                <?= $form->field($model['reg_form'], 'passport_series',
                                                                    ['options' => ['tag' => false, 'template' => "{input}"]])
                                                                    ->textInput(['class' => 'input', 'placeholder' => 'Серия'])->label(false) ?>
                                                                <div class="error__message fadeIn animated"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8 form__field-col">
                                                            <div class="form__field req-field numb-only-field" data-numb-length="6" data-name="d-passport-numb">
<!--                                                                <input type="text" class="input" placeholder="Номер">-->
                                                                <?= $form->field($model['reg_form'], 'passport_number',
                                                                    ['options' => ['tag' => false, 'template' => "{input}"]])
                                                                    ->textInput(['class' => 'input', 'placeholder' => 'Номер'])->label(false) ?>
                                                                <div class="error__message fadeIn animated"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Кем выдан
                                                </div>
                                                <div class="form__field req-field" data-name="d-passport-inst">
                                                    <?= $form->field($model['reg_form'], 'passport_issued',
                                                        ['options' => ['tag' => false, 'template' => "{input}"]])
                                                        ->textarea(['rows' => 2, 'cols' => 5, 'class' => 'input'])
                                                        ->label(false) ?>
                                                    <div class="error__message fadeIn animated"></div>
                                                </div>
                                            </div>
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Код подразделения
                                                </div>
                                                <div class="form__field form__field-small req-field pass-code" data-name="d-passport-code">
                                                    <?= $form->field($model['reg_form'], 'passport_code',
                                                        ['options' => ['tag' => false, 'template' => "{input}"]])
                                                        ->textInput(['class' => 'input'])->label(false) ?>
                                                    <div class="error__message fadeIn animated"></div>
                                                </div>
                                            </div>
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Дата выдачи
                                                </div>
                                                <div class="form__field form__field-small req-field date-field" data-name="d-passport-date">
                                                    <?= $form->field($model['reg_form'], 'passport_date',
                                                        ['options' => ['tag' => false, 'template' => "{input}"]])
                                                        ->textInput(['class' => 'input'])->label(false) ?>
                                                    <i class="icon__calendar show-calendat-js">
                                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2 14H14V5H2V14ZM15 3H13V1C13 0.448 12.552 0 12 0C11.448 0 11 0.448 11 1V3H5V1C5 0.448 4.552 0 4 0C3.448 0 3 0.448 3 1V3H1C0.448 3 0 3.448 0 4V15C0 15.552 0.448 16 1 16H15C15.552 16 16 15.552 16 15V4C16 3.448 15.552 3 15 3ZM4 9H6V7H4V9ZM7 9H9V7H7V9ZM10 9H12V7H10V9ZM4 12H6V10H4V12ZM7 12H9V10H7V12ZM10 12H12V10H10V12Z" fill="#1F1F1F"/>
                                                        </svg>
                                                    </i>
                                                    <div class="error__message fadeIn animated"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>






                                    <div data-step="4" class="form__step fadeIn animated">
                                        <div class="form__step-title">
                                            Контактные данные
                                        </div>
                                        <div id="main-address" class="form__group">
                                            <div class="form__group-title">
                                                Адрес регистрации по месту жительства (как в паспорте)
                                            </div>
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Укажите регион
                                                </div>
                                                <div class="form__field select-wrap req-field" data-name="d-region">
<!--                                                    <select data-placeholder="Выберите" class="input">-->
<!--                                                        <option label="-"></option>-->
<!--                                                        <option value="1">г. Москва</option>-->
<!--                                                        <option value="2">Московская область</option>-->
<!--                                                        <option value="3">Другой субъект РФ</option>-->
<!--                                                    </select>-->
                                                    <?php $region_list = Profile::_REGION;
                                                            array_unshift($region_list, " "); ?>
                                                    <?= $form->field($model['reg_form'], 'region', ['options' => ['tag' => false, 'template' => "{input}"],
                                                        'inputOptions' => ['class' => 'input', 'data-placeholder' => 'Выберите'],
                                                        'labelOptions' => []])
                                                        ->dropDownList($region_list)->label(false) ?>
                                                </div>
                                            </div>
                                            <div class="form__item form__item-horizontal form__item-disabled">
                                                <div class="form__item-label region-label">
                                                    Город, улица
                                                </div>
                                                <div class="form__fields">
                                                    <div class="row">
                                                        <div class="col-12 form__field-col">
                                                            <div class="form__field req-field fias-field" data-name="d-address-1">
<!--                                                                <input type="text" class="input">-->
                                                                <?= $form->field($model['reg_form'], 'address_passport_street',
                                                                    ['options' => ['tag' => false, 'template' => "{input}"]])
                                                                    ->textInput(['class' => 'input'])->label(false) ?>
                                                                <div class="hidden field-fias-id">
                                                                    <input type="hidden">
                                                                </div>
                                                                <div class="ac__box fadeIn animated">
                                                                    <div class="ac__box-bl scrollbar-dynamic">
                                                                        <div class="ac__list"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="error__message fadeIn animated"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 form__field-col">
                                                            <div class="form__item-label">
                                                                Дом
                                                            </div>
                                                            <div class="form__field req-field" data-name="d-house-1">
<!--                                                                <input type="text" class="input">-->
                                                                <?= $form->field($model['reg_form'], 'address_passport_building',
                                                                    ['options' => ['tag' => false, 'template' => "{input}"]])
                                                                    ->textInput(['class' => 'input'])->label(false) ?>
                                                                <div class="error__message fadeIn animated"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 form__field-col">
                                                            <div class="form__item-label">
                                                                Корпус
                                                            </div>
                                                            <div class="form__field numb-only-field" data-name="d-corpus-1" data-numb-length="4">
                                                                <input type="text" class="input">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 form__field-col">
                                                            <div class="form__item-label">
                                                                Строение
                                                            </div>
                                                            <div class="form__field" data-name="d-stroenie-1">
                                                                <input type="text" class="input">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 form__field-col">
                                                            <div class="form__item-label">
                                                                Номер квартиры (если есть)
                                                            </div>
                                                            <div class="form__field form__field-small numb-only-field" data-name="d-app-1" data-numb-length="4">
<!--                                                                <input type="text" class="input">-->
                                                                <?= $form->field($model['reg_form'], 'address_passport_apartment',
                                                                    ['options' => ['tag' => false, 'template' => "{input}"]])
                                                                    ->textInput(['class' => 'input'])->label(false) ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 form__field-col">
                                                            <div class="form__field">
                                                                <div class="checkbox__list">
                                                                    <div class="checkbox__item" data-name="same">
                                                                        <label>
                                                                            <input type="checkbox" checked name="the-same">
                                                                            <div class="checkbox__decor">
                                                                                <i class="icon__checked">
                                                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.00025 13.0002C5.74425 13.0002 5.48825 12.9022 5.29325 12.7072L1.29325 8.70725C0.90225 8.31625 0.90225 7.68425 1.29325 7.29325C1.68425 6.90225 2.31625 6.90225 2.70725 7.29325L6.00025 10.5862L13.2933 3.29325C13.6842 2.90225 14.3162 2.90225 14.7072 3.29325C15.0982 3.68425 15.0982 4.31625 14.7072 4.70725L6.70725 12.7072C6.51225 12.9022 6.25625 13.0002 6.00025 13.0002Z" fill="#195796"/>
                                                                                    </svg>
                                                                                </i>
                                                                            </div>
                                                                            <div class="checkbox__title">
                                                                                Совпадает с&nbsp;адресом фактического проживания
                                                                            </div>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div id="additional-address" class="form__group form-toggled animated fadeIn">
                                            <div class="form__group-title">
                                                Адрес по месту пребывания в г. Москве или Московской области
                                            </div>
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Регион, город, улица
                                                </div>
                                                <div class="form__fields">
                                                    <div class="row">
                                                        <div class="col-12 form__field-col">
                                                            <div class="form__field fias-field" data-name="d-address-2">
<!--                                                                <input type="text" class="input">-->
                                                                <?= $form->field($model['reg_form'], 'address_current_street',
                                                                    ['options' => ['tag' => false, 'template' => "{input}"]])
                                                                    ->textInput(['class' => 'input'])->label(false) ?>
                                                                <div class="hidden field-fias-id">
                                                                    <input type="hidden">
                                                                </div>
                                                                <div class="ac__box fadeIn animated">
                                                                    <div class="ac__box-bl scrollbar-dynamic">
                                                                        <div class="ac__list"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="error__message fadeIn animated"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 form__field-col">
                                                            <div class="form__item-label">
                                                                Дом
                                                            </div>
                                                            <div class="form__field" data-name="d-house-2">
<!--                                                                <input type="text" class="input">-->
                                                                <?= $form->field($model['reg_form'], 'address_current_building',
                                                                    ['options' => ['tag' => false, 'template' => "{input}"]])
                                                                    ->textInput(['class' => 'input'])->label(false) ?>
                                                                <div class="error__message fadeIn animated"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 form__field-col">
                                                            <div class="form__item-label">
                                                                Корпус
                                                            </div>
                                                            <div class="form__field numb-only-field" data-name="d-corpus-2" data-numb-length="4">
                                                                <input type="text" class="input">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 form__field-col">
                                                            <div class="form__item-label">
                                                                Строение
                                                            </div>
                                                            <div class="form__field" data-name="d-stroenie-2">
                                                                <input type="text" class="input">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 form__field-col">
                                                            <div class="form__item-label">
                                                                Номер квартиры (если есть)
                                                            </div>
                                                            <div class="form__field form__field-small numb-only-field" data-name="d-app-2" data-numb-length="4">
<!--                                                                <input type="text" class="input">-->
                                                                <?= $form->field($model['reg_form'], 'address_current_apartment',
                                                                    ['options' => ['tag' => false, 'template' => "{input}"]])
                                                                    ->textInput(['class' => 'input'])->label(false) ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form__group">
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Телефон
                                                </div>
                                                <div class="form__field form__field-small req-field phone-field" data-name="d-phone">
<!--                                                    <input type="text" placeholder="+7" class="input">-->
                                                    <?= $form->field($model['reg_form'], 'phone',
                                                        ['options' => ['tag' => false, 'template' => "{input}"]])
                                                        ->textInput(['class' => 'input', 'placeholder' => '+7'])->label(false) ?>
                                                    <div class="error__message fadeIn animated"></div>
                                                    <div class="form__item-hint">
                                                        Для уточнения документов и связи с вами
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Электронная почта
                                                </div>
                                                <div class="form__field form__field-small req-field" data-name="d-email">
<!--                                                    <input type="text" class="input">-->
                                                    <?= $form->field($model['reg_form'], 'email',
                                                        ['options' => ['tag' => false, 'template' => "{input}"]])
                                                        ->textInput(['class' => 'input'])->label(false) ?>
                                                    <div class="error__message fadeIn animated"></div>
                                                    <div class="form__item-hint">
                                                        Будьте внимательны, на&nbsp;этот адрес Вам будет отправлен пароль от&nbsp;Личного кабинета абитуриента
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label"></div>
                                                <div class="form__field">
                                                    <div class="checkbox__list">
                                                        <div class="checkbox__item" data-name="agree">
                                                            <label>
<!--                                                                <input type="checkbox" checked name="agree">-->

                                                                <?= $form->field(
                                                                        $model['reg_form'],
                                                                        'agree',
                                                                    ['options' => ['tag' => false, 'template' => "{input}"]]
                                                                )->checkbox([],false)->label(false) ?>

                                                                <div class="checkbox__decor">
                                                                    <i class="icon__checked">
                                                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.00025 13.0002C5.74425 13.0002 5.48825 12.9022 5.29325 12.7072L1.29325 8.70725C0.90225 8.31625 0.90225 7.68425 1.29325 7.29325C1.68425 6.90225 2.31625 6.90225 2.70725 7.29325L6.00025 10.5862L13.2933 3.29325C13.6842 2.90225 14.3162 2.90225 14.7072 3.29325C15.0982 3.68425 15.0982 4.31625 14.7072 4.70725L6.70725 12.7072C6.51225 12.9022 6.25625 13.0002 6.00025 13.0002Z" fill="#195796"/>
                                                                        </svg>
                                                                    </i>
                                                                </div>
                                                                <div class="checkbox__title">
                                                                    Я подтверждаю согласие на обработку моих <a href="#" target="_blank">персональных данных</a>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
<!---->
<!--                            <div class="form-group">-->
<!--                                --><?//= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
<!--                            </div>-->
<!---->
                            <?php ActiveForm::end(); ?>

                                </div>
                                <div class="form__actions form__actions-bd d-flex justify-content-between">
                                    <div class="steps__nav-box d-flex">
                                        <a href="#" class="btn__arrow back-js d-flex align-items-center justify-content-center fadeIn animated">
                                            <i class="icon__back">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M16.7071 5.70711C17.0976 5.31658 17.0976 4.68342 16.7071 4.29289C16.3166 3.90237 15.6834 3.90237 15.2929 4.29289L16.7071 5.70711ZM15.2929 19.7071C15.6834 20.0976 16.3166 20.0976 16.7071 19.7071C17.0976 19.3166 17.0976 18.6834 16.7071 18.2929L15.2929 19.7071ZM15.2929 4.29289L9 10.5858L10.4142 12L16.7071 5.70711L15.2929 4.29289ZM9 13.4142L15.2929 19.7071L16.7071 18.2929L10.4142 12L9 13.4142ZM9 10.5858C8.21895 11.3668 8.21895 12.6332 9 13.4142L10.4142 12L10.4142 12L9 10.5858Z" fill="#195796"/>
                                                </svg>
                                            </i>
                                        </a>
                                    </div>
                                    <div class="form__actions-btn-list">
                                        <div id="action-next" class="form__actions-btn-item fadeIn animated active">
                                            <button disabled type="button" class="btn__custom d-flex align-items-center justify-content-center next-step-js">
                                                Дальше
                                            </button>
                                        </div>
                                        <div id="action-submit" class="form__actions-btn-item fadeIn animated">
                                            <button type="submit" disabled class="btn__custom d-flex align-items-center justify-content-center submit-js">
                                                Отправить
                                            </button>
                                        </div>
                                        <div id="action-dog" class="form__actions-btn-item fadeIn animated">
                                            <button type="button" class="btn__custom d-flex align-items-center justify-content-center">
                                                Продолжить по договору
                                            </button>
                                        </div>
                                        <div id="action-site" class="form__actions-btn-item fadeIn animated">
                                            <a href="https://www.mos.ru/" target="_blank" class="btn__custom d-flex align-items-center justify-content-center next-step-js">
                                                Перейти на mos.ru
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                        <div class="reg__result reg-state fadeIn animated">
                            <div class="reg__result-content text-center">
                                <div class="reg__result-icon">
                                    <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22 39C31.3888 39 39 31.3888 39 22C39 12.6112 31.3888 5 22 5C12.6112 5 5 12.6112 5 22C5 31.3888 12.6112 39 22 39Z" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.7071 22.2929L15.2929 21.7071C15.6834 21.3166 16.3166 21.3166 16.7071 21.7071L19.2547 24.2547C19.6598 24.6598 20.3218 24.6424 20.7051 24.2166L28.2949 15.7834C28.6782 15.3576 29.3402 15.3402 29.7453 15.7453L30.323 16.323C30.7015 16.7015 30.7148 17.3111 30.353 17.7058L20.7057 28.2301C20.321 28.6498 19.6641 28.6641 19.2615 28.2615L14.7071 23.7071C14.3166 23.3166 14.3166 22.6834 14.7071 22.2929Z" fill="#B4E3F9" stroke="#145797" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="reg__result-title">
                                    Мы сохранили ваши данные, осталось совсем немного
                                </div>
                                <div class="reg__result-text">
                                    Что бы продолжить заполнять заявку на обучение, проверьте вашу почту<br>
                                    <b>mail@box.ru</b> куда мы выслали пароль и войдите в личный кабинет
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="login-lk" class="col-lg-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 tabs__lk-pane fadeIn animated side-right">
                    <div class="sc__box-header hidden-md-down">
                        <div class="sc__box-title seo__item">
                            Вход
                        </div>
                    </div>
<!--                    <div class="ct__box">-->
<!--                        <form autocomplete="off" method="post" action="" class="form-login">-->
<!--                            <div class="form__list">-->
<!--                                <div class="form__item">-->
<!--                                    <div class="form__item-label">-->
<!--                                        Ваш e-mail-->
<!--                                    </div>-->
<!--                                    <div class="form__item-field email-field req-field" data-name="d-email">-->
<!--                                        <input type="text" autocomplete="off" placeholder="" class="input">-->
<!--                                        <div class="error__message"></div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="form__item">-->
<!--                                    <div class="form__item-label">-->
<!--                                        Пароль-->
<!--                                    </div>-->
<!--                                    <div class="form__item-field req-field" data-name="d-password">-->
<!--                                        <input type="password" autocomplete="off" placeholder="" class="input">-->
<!--                                        <div class="error__message"></div>-->
<!--                                    </div>-->
<!---->
<!--                                </div>-->
<!--                                <div class="form__item">-->
<!--                                    <button type="submit" disabled class="btn__custom btn__custom-full d-flex align-items-center justify-content-center">-->
<!--                                        Войти-->
<!--                                    </button>-->
<!--                                </div>-->
<!--                                <div class="form__item">-->
<!--                                    <div class="form__link">-->
<!--                                        <a href="#recovery-modal" data-touch="false" data-modal="true" data-fancybox="">-->
<!--                                            Забыли пароль?-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </form>-->
<!--                    </div>-->

                    <div class="ct__box">
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'options' => [
                            'class' => 'form-login'
                        ],
                        'action' => 'site/login',
                        'enableAjaxValidation'   => false,
                        'enableClientValidation' => false,
                        'validateOnBlur'         => false,
                        'validateOnType'         => false,
                        'validateOnChange'       => false,
                        'validateOnSubmit'       => true,
                    ]); ?>
                        <div class="form__list">
                            <div class="form__item">
                                <div class="form__item-label">
                                    Ваш e-mail
                                </div>
                                <div class="form__item-field email-field req-field" data-name="d-email">
                                    <?= $form->field($model['login_form'], 'username', ['options' => ['tag' => false, 'template' => "{input}"]])->textInput(['class' => 'input'])->label(false) ?>
                                    <div class="error__message"></div>
                                </div>
                            </div>
                            <div class="form__item">
                                <div class="form__item-label">
                                    Пароль
                                </div>
                                <div class="form__item-field req-field" data-name="d-password">
                                    <?= $form->field($model['login_form'], 'password', ['options' => ['tag' => false, 'template' => "{input}"]])->passwordInput(['class' => 'input'])->label(false) ?>
                                    <div class="error__message"></div>
                                </div>
                            </div>

                                    <?= $form->field($model['login_form'], 'rememberMe', ['options' => ['tag' => false, 'template' => "{input}"]])->checkbox() ?>

                            <div class="form__item">
                                <?= Html::submitButton('Войти',
                                    [
                                        'class' => 'btn__custom btn__custom-full d-flex align-items-center justify-content-center',
                                        'name' => 'login-button',
                                        'disabled' => 'disabled'
                                    ]) ?>
                            </div>
                            <div class="form__item">
                                <div class="form__link">
                                    <a href="/site/request-password-reset" data-touch="false" data-modal="true" data-fancybox="">
                                        Забыли пароль?
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php ActiveForm::end(); ?>
                    </div>


                </div>
            </div>
        </div>

    </div>

</div>