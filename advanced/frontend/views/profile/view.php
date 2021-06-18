<?php

use common\models\Application;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Profile;
use yii\widgets\Pjax;

//print_r($model->education_files);

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    /*.message-area + .sc__box-header {*/
    /*    margin-top: 50px;*/
    /*}*/
    #profile p.help-block.help-block-error {
        margin-bottom:0;
    }
    .img-uploaded {
        width: 100px;
        height: 80px;
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        display: inline-block;
        margin-bottom: 1em;
        margin-right: 1em;
    }
    .field-fileform-imagefile .help-block {
        font-size: 14px;
        line-height: 20px;
        color: rgba(31, 31, 31, 0.6);
        margin-top: 1em;
    }
</style>

<div class="section sc__lk sc__lk-profile sides">
    <div class="container">
        <div class="sc__lk-content">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 active">



                    <div class="message-area">
                        <?php Pjax::begin(); ?>
                        <?php if (count($messages)): ?>
                            <div class="sc__box-header">
                                <div class="sc__box-title seo__item">
                                    Сообщения
                                </div>
                            </div>
                            <div class="ct__box" style="margin-bottom: 2.5em;">
                                <ul>
                                    <?php foreach ($messages as $message): ?>
                                        <li>
                                            <?= $message->getText() ?>
                                            <!--                        --><?//= $message->appl_id ?>
                                            <?php $url = '/message/' . $message->id . '/dont-show'; ?>
                                            <?= Html::a('Больше не показывать', [$url], ['class' => 'dont-show-message-button']) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <?php Pjax::end(); ?>
                    </div>

                    <div data-parent="orders" class="sc__box-header toggle__mb-content active">
                        <div class="sc__box-title seo__item">
                            Заявки на обучение
                        </div>
                    </div>


                    <div id="orders" class="ct__box ct__box-orders mb-content" style="display: block;">
                        <div class="order__list">


                            <?php if (!count($sent_applications[0])): ?>


                                <div class="orders__item orders__item-start">

                                    <?php
                                    $options = $available_programs;
                                    foreach ($available_programs as $program_id => $program_name) {
                                        if (array_key_exists($program_id, $sent_applications[0])
                                            && $sent_applications[0][$program_id][1] != Application::STATUS_DECLINED)
                                            unset($options[$program_id]);
                                    }
                                    //            if (count($options)):
                                    ?>

                                    <?php $form = ActiveForm::begin([
                                        'id' => 'application-form',
                                        'options' => ['enctype' => 'multipart/form-data'],
//                                  'action' => '/profile',
                                    ]) ?>


                                    <div class="form__group">
                                        <div class="form__flex-group d-flex align-items-start">
                                            <div class="form__item form__flex-fixed">
                                                <div class="form__item-label">
                                                    Программа обучения
                                                </div>
                                                <div class="select-wrap field-prog">
                                                    <?= $form->field($appform, 'program_id', ['options' => ['tag' => false, 'template' => "{input}"],
                                                        'inputOptions' => ['class' => 'select'],
                                                        'labelOptions' => []])
                                                        ->dropDownList($options)->label(false) ?>
                                                </div>
                                            </div>
                                            <div></div>
                                        </div>
                                    </div>

                                    <?php ActiveForm::end() ?>


                                    <div class="form__group form__group-disabled form__group-text">
                                        <div class="custom-text">
                                            <p><b>Список документов:</b></p>
                                            <ul>
                                                <li>паспорт (страница с фото, страница с пропиской)</li>
                                                <li>временная регистрации (при наличии)</li>
                                                <li>документы об образовании (включая приложение с оценками с двух сторон)</li>
                                                <li>документы, подтверждающие личные достижения (при наличии)</li>
                                                <p>Перед отправкой убедитесь, что все необходимые документы загружены.</p>
                                            </ul>

                                        </div>
                                    </div>


                                    <div class="form__group form__group-files">

                                        <?php Pjax::begin(); ?>
                                        <?php $form2 = ActiveForm::begin([
                                            'id' => 'upload-form-passport',
                                            'action' => '/profile/upload-file',
                                            'options' => ['enctype' => 'multipart/form-data','class' => 'upload-form'],
                                            'enableClientValidation' => false,
                                        ]) ?>

                                        <?= $form2->field($file_form, 'doctype')->hiddenInput(['value'=>'1'])->label(false) ?>

                                        <div class="image-container">
                                            <?php if (is_array($model->passport_files)): ?>
                                                <?php foreach ($model->passport_files as $file): ?>
                                                    <a target="_blank" href="/uploads/<?= $file['name'] ?>">
                                                        <div class="img-uploaded"
                                                             style="background-image: url('/uploads/<?= $file['name'] . '?' . time() ?>')" >&nbsp;
                                                        </div>
<!--                                                        <div>удалить</div>-->
                                                    </a>
                                                <?php endforeach;?>
                                            <?php endif; ?>
                                        </div>

                                        <?= $form2->field($file_form, 'imageFile')->fileInput()->label(false)
                                            ->hint('Только файлы в формате .jpg размером не более 5000x5000 px.') ?>

                                        <div class="xhr-message"></div>
                                        <?php ActiveForm::end() ?>
                                        <?php Pjax::end(); ?>

                                    </div>

                                    <div class="form__group form__group-actions d-flex align-items-center">
                                        <button name="signup-button" type="submit" class="btn__custom d-flex align-items-center justify-content-center">
                                            Отправить
                                        </button>
                                        <div class="form__group-hint">
                                            Перед отправкой убедитесь, что все документы прикреплены
                                        </div>
                                    </div>
                                </div>


                            <?php else: ?>


                                <?php foreach($sent_applications[1] as $application): ?>
                                    <div class="orders__item orders__item-result">
                                        <div class="orders__item-title">
                                            <?= $application->program->name ?>
                                        </div>
                                        <div class="status__wrap d-flex">
                                            <div class="status status-color-<?= $application->status ?>">
                                                <?= Application::STATUSES[$application->status] ?>
                                            </div>
                                        </div>


                                        <?php if ($application->status == Application::STATUS_DECLINED): ?>

                                            <div class="orders__item-info-box">
                                                <div class="orders__item-info-title">
                                                    Комментарий:
                                                </div>
                                                <div class="orders__item-info-text">
                                                    <ul>
                                                        <?php foreach($application->getDeclineMessages() as $message): ?>
                                                            <li><?= $message->template->summary ?> (<?= date('d.m.Y', $message->created) ?>)</li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                                <div class="orders__item-link">
                                                    <div>Вы можете отправить заявку снова после устранения недостатков, указанных в комментарии.</div>
                                                    <div><?= Html::a('Отправить еще раз', ['profile/application/form'], [
//                                                            'class' => 'btn btn-primary'
                                                        ]) ?></div>
                                                </div>
                                            </div>

                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>

<!--                                <div class="status__wrap d-flex">-->
<!--                                    <div class="status status-color-1">-->
<!--                                        Заявка отправлена-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="status__wrap d-flex">-->
<!--                                    <div class="status status-color-2">-->
<!--                                        Документы приняты-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="status__wrap d-flex">-->
<!--                                    <div class="status status-color-3">-->
<!--                                        Дополните документы-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="status__wrap d-flex">-->
<!--                                    <div class="status status-color-4">-->
<!--                                        Зарегистрирован-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="status__wrap d-flex">-->
<!--                                    <div class="status status-color-5">-->
<!--                                        Заявка у оператора-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="status__wrap d-flex">-->
<!--                                    <div class="status status-color-6">-->
<!--                                        Отказано в регистрации-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="status__wrap d-flex">-->
<!--                                    <div class="status status-color-7">-->
<!--                                        Отказано в регистрации-->
<!--                                    </div>-->
<!--                                </div>-->

                                <?php if ((bool)(count($available_programs) - count($sent_applications[0]))): ?>
                                    <div class="orders__item orders__item-new">
                                        <div class="actions__wrap d-flex">
                                            <a href="/profile/application/form" class="btn__custom btn__custom-grey d-flex align-items-center justify-content-center">
                                                Новая заявка
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            <?php endif; ?>

                        </div>
                    </div>


                    <div data-parent="profile" class="sc__box-header toggle__mb-content">
                        <div class="sc__box-title seo__item">
                            Профиль
                        </div>
                    </div>


                    <div id="profile" class="ct__box ct__box-profile mb-content">
                        <div class="toggle__boxes">


                            <?php $form = ActiveForm::begin([
                                'id' => 'edit-profile-form',
                                'action' => '/profile/edit',
                                'enableAjaxValidation'   => false,
                                'enableClientValidation' => true,
                                'validateOnBlur'         => false,
                                'validateOnType'         => false,
                                'validateOnChange'       => false,
                                'validateOnSubmit'       => true,
                            ]);

                            $edit_profile_form->birthdate = date("d.m.Y", strtotime($edit_profile_form->birthdate));
                            $edit_profile_form->passport_date = date("d.m.Y", strtotime($edit_profile_form->passport_date));

                            //                            echo '<pre>';
                            //                            print_r($edit_profile_form);
                            //                            echo '</pre>';

                            ?>


                            <div class="toggle__box">

                                <div class="toggle__box-header">
                                    <div class="toggle__box-title">
                                        Личные данные
                                    </div>
                                    <div class="toggle__arrow">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.00025 11.0002C7.74425 11.0002 7.48825 10.9023 7.29325 10.7073L2.29325 5.70725C1.90225 5.31625 1.90225 4.68425 2.29325 4.29325C2.68425 3.90225 3.31625 3.90225 3.70725 4.29325L8.00025 8.58625L12.2933 4.29325C12.6842 3.90225 13.3162 3.90225 13.7072 4.29325C14.0982 4.68425 14.0982 5.31625 13.7072 5.70725L8.70725 10.7073C8.51225 10.9023 8.25625 11.0002 8.00025 11.0002Z" fill="#1F1F1F"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="toggle__box-content">
                                    <div class="toggle__box-content-bl">
                                        <div class="form__group">
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Фамилия
                                                </div>
                                                <div class="form__field req-field" data-name="d-surname">
                                                    <?= $form->field($edit_profile_form, 'lastname', ['options' => ['tag' => false, 'template' => "{input}"]])
                                                        ->textInput(['class' => 'input'])->label(false) ?>
                                                    <div class="error__message fadeIn animated"></div>
                                                </div>
                                            </div>
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Имя
                                                </div>
                                                <div class="form__field req-field" data-name="d-name">
                                                    <?= $form->field($edit_profile_form, 'firstname', ['options' => ['tag' => false, 'template' => "{input}"]])
                                                        ->textInput(['class' => 'input'])->label(false) ?>
                                                    <div class="error__message fadeIn animated"></div>
                                                </div>
                                            </div>
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Отчество
                                                </div>
                                                <div class="form__field">
                                                    <?= $form->field($edit_profile_form, 'patronim', ['options' => ['tag' => false, 'template' => "{input}"]])
                                                        ->textInput(['class' => 'input'])->label(false) ?>
                                                </div>
                                            </div>
<!--                                            <div class="form__item form__item-horizontal">-->
<!--                                                <div class="form__item-label">-->
<!--                                                    Гражданство-->
<!--                                                </div>-->
<!--                                                <div class="select-wrap" data-name="d-nationality">-->
<!--                                                    <select data-placeholder="Выберите">-->
<!--                                                        <option value="1">-->
<!--                                                            Российская Федерация-->
<!--                                                        </option>-->
<!--                                                        <option value="2">-->
<!--                                                            Другое-->
<!--                                                        </option>-->
<!--                                                    </select>-->
<!--                                                </div>-->
<!--                                            </div>-->
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Дата рождения
                                                </div>
                                                <div class="form__field form__field-small date-field req-field" data-name="d-birthday">
                                                    <?= $form->field($edit_profile_form, 'birthdate', ['options' => ['tag' => false, 'template' => "{input}"]])
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
                                                    <?= $form->field($edit_profile_form, 'snils', ['options' => ['tag' => false, 'template' => "{input}"]])
                                                        ->textInput(['class' => 'input'])->label(false) ?>
                                                    <div class="error__message fadeIn animated"></div>
                                                </div>
                                            </div>
                                            <div class="form__item form__item-horizontal gender-field">
                                                <div class="form__item-label">
                                                    Пол
                                                </div>
                                                <div class="btn__group btn__group-radio d-flex">
<!--                                                    <div class="btn__group-item">-->
<!--                                                        <label>-->
<!--                                                            <input checked type="radio" name="sex" value="1">-->
<!--                                                            <div class="btn__radio d-flex align-items-center">-->
<!--                                                                Мужской-->
<!--                                                            </div>-->
<!--                                                        </label>-->
<!--                                                    </div>-->
<!--                                                    <div class="btn__group-item">-->
<!--                                                        <label>-->
<!--                                                            <input type="radio" name="sex" value="2">-->
<!--                                                            <div class="btn__radio d-flex align-items-center">-->
<!--                                                                Женский-->
<!--                                                            </div>-->
<!--                                                        </label>-->
<!--                                                    </div>-->

                                                    <?= $form->field($edit_profile_form, 'gender', ['options' => ['tag' => false]])
                                                        ->inline(true)
                                                        ->radioList(
                                                            Profile::_GENDER,
                                                            [
                                                                'class' => 'd-flex',
                                                                'item' => function($index, $label, $name, $checked, $value) {

                                                                    $status = ($checked) ? 'checked' : '';

                                                                    $return = "\n\n".'<div class="btn__group-item">
    <label>'
                                                                        . "\n".'       <input type="radio" ' . $status . ' name="' . $name . '" value="' . $value . '">'
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
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label hidden-sm-down"></div>
                                                <button type="submit" class="btn__custom d-flex align-items-center justify-content-center">
                                                    Сохранить
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="toggle__box">
                                <div class="toggle__box-header">
                                    <div class="toggle__box-title">
                                        Образование
                                    </div>
                                    <div class="toggle__arrow">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.00025 11.0002C7.74425 11.0002 7.48825 10.9023 7.29325 10.7073L2.29325 5.70725C1.90225 5.31625 1.90225 4.68425 2.29325 4.29325C2.68425 3.90225 3.31625 3.90225 3.70725 4.29325L8.00025 8.58625L12.2933 4.29325C12.6842 3.90225 13.3162 3.90225 13.7072 4.29325C14.0982 4.68425 14.0982 5.31625 13.7072 5.70725L8.70725 10.7073C8.51225 10.9023 8.25625 11.0002 8.00025 11.0002Z" fill="#1F1F1F"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="toggle__box-content">
                                    <div class="toggle__box-content-bl">
                                        <div class="form__group">
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Уровень образования
                                                </div>
                                                <div class="select-wrap">
                                                    <?= $form->field($edit_profile_form, 'education_level', ['options' => ['tag' => false, 'template' => "{input}"],
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
                                                    <?= $form->field($edit_profile_form, 'institution', ['options' => ['tag' => false, 'template' => "{input}"]])
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
                                                    <?= $form->field($edit_profile_form, 'graduate_year', ['options' => ['tag' => false, 'template' => "{input}"]])
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
                                                <div class="form__fields">
                                                    <div class="row">
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 form__field-col">
                                                            <div class="form__field" data-name="d-inst-serial">
<!--                                                                <input type="text" value="ПН" class="input" placeholder="Серия">-->
                                                                <?= $form->field($edit_profile_form, 'certificate_series', ['options' => ['tag' => false, 'template' => "{input}"]])
                                                                    ->textInput(['class' => 'input', 'placeholder' => 'Серия'])->label(false) ?>
                                                                <div class="error__message fadeIn animated"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8 form__field-col">
                                                            <div class="form__field req-field" data-name="d-inst-numb">
<!--                                                                <input type="text" value="1243-455" class="input" placeholder="Номер">-->
                                                                <?= $form->field($edit_profile_form, 'certificate_number', ['options' => ['tag' => false, 'template' => "{input}"]])
                                                                    ->textInput(['class' => 'input', 'placeholder' => 'Номер'])->label(false) ?>
                                                                <div class="error__message fadeIn animated"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label hidden-sm-down"></div>
                                                <button type="submit" class="btn__custom d-flex align-items-center justify-content-center">
                                                    Сохранить
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="toggle__box">
                                <div class="toggle__box-header">
                                    <div class="toggle__box-title">
                                        Паспорт
                                    </div>
                                    <div class="toggle__arrow">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.00025 11.0002C7.74425 11.0002 7.48825 10.9023 7.29325 10.7073L2.29325 5.70725C1.90225 5.31625 1.90225 4.68425 2.29325 4.29325C2.68425 3.90225 3.31625 3.90225 3.70725 4.29325L8.00025 8.58625L12.2933 4.29325C12.6842 3.90225 13.3162 3.90225 13.7072 4.29325C14.0982 4.68425 14.0982 5.31625 13.7072 5.70725L8.70725 10.7073C8.51225 10.9023 8.25625 11.0002 8.00025 11.0002Z" fill="#1F1F1F"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="toggle__box-content">
                                    <div class="toggle__box-content-bl">
                                        <div class="form__group">
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Серия, номер
                                                </div>
                                                <div class="form__fields">
                                                    <div class="row">
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 form__field-col">
                                                            <div class="form__field req-field numb-only-field" data-numb-length="4" data-name="d-passport-serial">
<!--                                                                <input type="text" value="21" class="input" placeholder="Серия">-->
                                                                <?= $form->field($edit_profile_form, 'passport_series',
                                                                    ['options' => ['tag' => false, 'template' => "{input}"]])
                                                                    ->textInput(['class' => 'input', 'placeholder' => 'Серия'])->label(false) ?>
                                                                <div class="error__message fadeIn animated"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8 form__field-col">
                                                            <div class="form__field req-field numb-only-field" data-numb-length="6" data-name="d-passport-numb">
<!--                                                                <input type="text" value="232525" class="input" placeholder="Номер">-->
                                                                <?= $form->field($edit_profile_form, 'passport_number',
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
<!--                                                    <textarea class="input">Московским РУВД</textarea>-->
                                                    <?= $form->field($edit_profile_form, 'passport_issued',
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
<!--                                                    <input value="256032" type="text" class="input">-->
                                                    <?= $form->field($edit_profile_form, 'passport_code',
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
                                                    <?= $form->field($edit_profile_form, 'passport_date',
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
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label hidden-sm-down"></div>
                                                <button type="submit" class="btn__custom d-flex align-items-center justify-content-center">
                                                    Сохранить
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="toggle__box">
                                <div class="toggle__box-header">
                                    <div class="toggle__box-title">
                                        Контактные данные
                                    </div>
                                    <div class="toggle__arrow">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.00025 11.0002C7.74425 11.0002 7.48825 10.9023 7.29325 10.7073L2.29325 5.70725C1.90225 5.31625 1.90225 4.68425 2.29325 4.29325C2.68425 3.90225 3.31625 3.90225 3.70725 4.29325L8.00025 8.58625L12.2933 4.29325C12.6842 3.90225 13.3162 3.90225 13.7072 4.29325C14.0982 4.68425 14.0982 5.31625 13.7072 5.70725L8.70725 10.7073C8.51225 10.9023 8.25625 11.0002 8.00025 11.0002Z" fill="#1F1F1F"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="toggle__box-content">
                                    <div class="toggle__box-content-bl">
                                        <div class="form__group">

                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Адрес регистрации по месту жительства (по паспорту)
                                                </div>
                                                <div class="form__field req-field" data-name="d-passport-inst">
                                                    <?= $form->field($edit_profile_form, 'address_passport',
                                                        ['options' => ['tag' => false, 'template' => "{input}"]])
                                                        ->textarea(['rows' => 2, 'cols' => 5, 'class' => 'input'])
                                                        ->label(false) ?>
                                                    <div class="error__message fadeIn animated"></div>
                                                </div>
                                            </div>



                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Адрес по месту пребывания в г. Москве или Московской области
                                                </div>
                                                <div class="form__field req-field" data-name="d-passport-inst">
                                                    <?= $form->field($edit_profile_form, 'address_current',
                                                        ['options' => ['tag' => false, 'template' => "{input}"]])
                                                        ->textarea(['rows' => 2, 'cols' => 5, 'class' => 'input'])
                                                        ->label(false) ?>
                                                    <div class="error__message fadeIn animated"></div>
                                                </div>
                                            </div>


                                        </div>



                                        <div class="form__group">
                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label">
                                                    Телефон
                                                </div>
                                                <div class="form__field form__field-small req-field phone-field" data-name="d-phone">
<!--                                                    <input type="text" value="+798327465573" placeholder="+7" class="input">-->
                                                    <?= $form->field($edit_profile_form, 'phone',
                                                        ['options' => ['tag' => false, 'template' => "{input}"]])
                                                        ->textInput(['class' => 'input', 'placeholder' => '+7'])->label(false) ?>
                                                    <div class="error__message fadeIn animated"></div>
                                                    <div class="form__item-hint">
                                                        Для уточнения документов и связи с вами
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form__item form__item-horizontal">
                                                <div class="form__item-label hidden-sm-down"></div>
                                                <button type="submit" class="btn__custom d-flex align-items-center justify-content-center">
                                                    Сохранить
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <?php ActiveForm::end(); ?>

                            <div style="padding-top: 20px">
                                <a href="/site/request-password-reset">Сброс пароля</a>
                            </div>






<!--                            <div class="toggle__box">-->
<!--                                <div class="toggle__box-header">-->
<!--                                    <div class="toggle__box-title">-->
<!--                                        Смена пароля-->
<!--                                    </div>-->
<!--                                    <div class="toggle__arrow">-->
<!--                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">-->
<!--                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.00025 11.0002C7.74425 11.0002 7.48825 10.9023 7.29325 10.7073L2.29325 5.70725C1.90225 5.31625 1.90225 4.68425 2.29325 4.29325C2.68425 3.90225 3.31625 3.90225 3.70725 4.29325L8.00025 8.58625L12.2933 4.29325C12.6842 3.90225 13.3162 3.90225 13.7072 4.29325C14.0982 4.68425 14.0982 5.31625 13.7072 5.70725L8.70725 10.7073C8.51225 10.9023 8.25625 11.0002 8.00025 11.0002Z" fill="#1F1F1F"/>-->
<!--                                        </svg>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="toggle__box-content">-->
<!--                                    <div class="toggle__box-content-bl">-->
<!--                                        <div class="form__group">-->
<!--                                            <div class="form__item form__item-horizontal">-->
<!--                                                <div class="form__item-label">-->
<!--                                                    Старый пароль-->
<!--                                                </div>-->
<!--                                                <div class="form__field form__field-small req-field" data-name="d-pass-1">-->
<!--                                                    <input type="password" type="text" class="input">-->
<!--                                                    <div class="error__message fadeIn animated"></div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div class="form__item form__item-horizontal">-->
<!--                                                <div class="form__item-label">-->
<!--                                                    Новый пароль-->
<!--                                                </div>-->
<!--                                                <div class="form__field form__field-small req-field" data-name="d-pass-2">-->
<!--                                                    <input type="password" class="input">-->
<!--                                                    <div class="error__message fadeIn animated"></div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div class="form__item form__item-horizontal">-->
<!--                                                <div class="form__item-label hidden-sm-down"></div>-->
<!--                                                <button disabled type="submit" class="btn__custom d-flex align-items-center justify-content-center">-->
<!--                                                    Сохранить-->
<!--                                                </button>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->




                        </div>
                    </div>
                </div>



                <div class="col-xl-4 col-lg-4 col-lg-4 col-md-12 col-sm-12 col-12 side-right">
                    <div data-parent="education" class="sc__box-header toggle__mb-content">
                        <div class="sc__box-title seo__item">
                            Обучение
                        </div>
                    </div>
                    <div id="education" class="ct__box ct__box-card mb-content">

                        <?php $accepted = [];
                        if (count($sent_applications[0]))
                            foreach($sent_applications[0] as $prog_id => $program)
                                if ($program[1]==3)
                                    $accepted[] = $program[0]; ?>

                        <?php if (count($accepted)): ?>

                            <div class="ct__box-bl">
                                <div class="profile__header d-flex align-items-center">
                                    <div class="profile__header-icon">
                                        <svg viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M22 20C18.7 20 16 17.3 16 14V11C16 7.7 18.7 5 22 5C25.3 5 28 7.7 28 11V14C28 17.3 25.3 20 22 20Z" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M32 39H12C10.9 39 10 38.1 10 37V34C10 28.5 14.5 24 20 24H24C29.5 24 34 28.5 34 34V37C34 38.1 33.1 39 32 39Z" fill="#B4E3F9" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <div class="profile__name">
                                        <?= $model->profile->lastname ?><br>
                                        <?= $model->profile->firstname ?> <?= $model->profile->patronim ?>
                                    </div>
                                </div>
                                <div class="ct__message ct__message-ok">
                                    Одобрена ваша заявка на обучение по программе:
                                        <?php foreach($accepted as $program): ?>
                                            <div><?= $program ?></div>
                                        <?php endforeach; ?>
                                </div>
                            </div>


                        <?php else: ?>

                            <div class="ct__box-bl">
                                <div class="profile__header d-flex align-items-center">
                                    <div class="profile__header-icon">
                                        <svg viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M22 20C18.7 20 16 17.3 16 14V11C16 7.7 18.7 5 22 5C25.3 5 28 7.7 28 11V14C28 17.3 25.3 20 22 20Z" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M32 39H12C10.9 39 10 38.1 10 37V34C10 28.5 14.5 24 20 24H24C29.5 24 34 28.5 34 34V37C34 38.1 33.1 39 32 39Z" fill="#B4E3F9" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <div class="profile__name">
                                        <?= $model->profile->lastname ?><br>
                                        <?= $model->profile->firstname ?> <?= $model->profile->patronim ?>
                                    </div>
                                </div>
                                <div class="text">
                                    В настоящее время Вы не зарегистрированы на обучение в ГБПОУ ДЗМ «МК №7»
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>









                    <div data-parent="info" class="sc__box-header toggle__mb-content">
                        <div class="sc__box-title seo__item">
                            О поступлении
                        </div>
                    </div>
                    <div id="info" class="ct__box ct__box-info mb-content">
                        <div class="link__list">
                            <div class="link__item">
                                <a href="#doc-modal" data-fancybox="">
                                    Список документов для поступления
                                </a>
                            </div>

                            <div class="link__item">
                                <a target="_blank" href="https://medcollege7.ru/pk2021/med-osmotr.pdf">
                                    Информация о необходимости прохождения предварительных медицинских осмотров (обследований)
                                </a>
                            </div>


                            <div class="link__item">
                                <a href="#doc-modal-perevod" data-fancybox="">
                                    Порядок перевода в колледж из другой образовательной организации
                                </a>
                            </div>

                            <div class="link__item">
                                <a target="_blank" href="https://medcollege7.ru/pk2021/poryadok-podachi.pdf">
                                    Порядок подачи заявлений
                                </a>
                            </div>

                            <div class="link__item">
                                <a href="#doc-modal-budget" data-fancybox="">
                                    Условия приема на обучение за счет ассигнований бюджета города Москвы
                                </a>
                            </div>

                            <div class="link__item">
                                <a href="#doc-modal-dogovor" data-fancybox="">
                                    Условия приема на обучение по договорам
                                </a>
                            </div>

                            <div class="link__item">
                                <a href="#doc-modal-exam" data-fancybox="">
                                    Перечень вступительных испытаний для поступления на обучение
                                </a>
                            </div>
                        </div>
                    </div>
                </div>





            </div>
        </div>

    </div>
</div>
<div class="section sc__instruction">
    <div class="container">
        <a href="#" class="close__box">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.29289 4.29289C4.68342 3.90237 5.31658 3.90237 5.70711 4.29289L12 10.5858L18.2929 4.29289C18.6834 3.90237 19.3166 3.90237 19.7071 4.29289C20.0976 4.68342 20.0976 5.31658 19.7071 5.70711L13.4142 12L19.7071 18.2929C20.0976 18.6834 20.0976 19.3166 19.7071 19.7071C19.3166 20.0976 18.6834 20.0976 18.2929 19.7071L12 13.4142L5.70711 19.7071C5.31658 20.0976 4.68342 20.0976 4.29289 19.7071C3.90237 19.3166 3.90237 18.6834 4.29289 18.2929L10.5858 12L4.29289 5.70711C3.90237 5.31658 3.90237 4.68342 4.29289 4.29289Z" fill="#1F1F1F"/>
            </svg>
        </a>
        <div data-parent="instruction" class="sc__box-header toggle__mb-content">
            <div class="sc__box-title seo__item">
                Инструкция
            </div>
        </div>
        <div id="instruction" class="mb-content">
            <div class="mb-content-box">
                <div class="sc__box-bl">
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                            <div class="text">
                                По работе в Личном кабинете слушателя с использованием Системы электронной регистрации на обучение по ДПО, ПО, ЕМИАС в Государственном бюджетном профессиональном образовательном учреждении Департамента здравоохранения города Москвы «Медицинский колледж No 7»
                            </div>
<!--                            <div class="actions__wrap fadeIn animated active d-flex">-->
<!--                                <a href="#" class="btn__border d-flex align-items-center toggle__instr-js">-->
<!--                                    Показать все-->
<!--                                </a>-->
<!--                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="sc__box-bl fadeIn animated">
                    <div class="sc__box-header">
                        <div class="custom-text">
                            <h3>Блоки в личном кабинете</h3>
                        </div>
                    </div>
                    <div class="icon__ct-list">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 icon__ct-item">
                                <div class="icon__ct-item-bl d-flex">
                                    <div class="icon__ct-item-img d-flex align-items-center justify-content-center">
                                        <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M22 20C18.7 20 16 17.3 16 14V11C16 7.7 18.7 5 22 5C25.3 5 28 7.7 28 11V14C28 17.3 25.3 20 22 20Z" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M32 39H12C10.9 39 10 38.1 10 37V34C10 28.5 14.5 24 20 24H24C29.5 24 34 28.5 34 34V37C34 38.1 33.1 39 32 39Z" fill="#B4E3F9" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <div class="icon__ct-item-content">
                                        <div class="icon__ct-item-title">
                                            Профиль
                                        </div>
                                        <div class="icon__ct-item-text">
                                            заполнение и редактирование профиля
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 icon__ct-item">
                                <div class="icon__ct-item-bl d-flex">
                                    <div class="icon__ct-item-img d-flex align-items-center justify-content-center">
                                        <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 39H32C33.1 39 34 38.1 34 37V13H29C27.9 13 27 12.1 27 11V5H12C10.9 5 10 5.9 10 7V37C10 38.1 10.9 39 12 39Z" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M34 13L27 5" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M21 9H14V14H21V9Z" fill="#B4E3FA" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M14 19H30" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M14 23H30" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M14 27H30" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M14 31H22" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <div class="icon__ct-item-content">
                                        <div class="icon__ct-item-title">
                                            Заявки
                                        </div>
                                        <div class="icon__ct-item-text">
                                            добавление новой или просмотр поданной заявки на обучение
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 icon__ct-item">
                                <div class="icon__ct-item-bl d-flex">
                                    <div class="icon__ct-item-img d-flex align-items-center justify-content-center">
                                        <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M22 7L5 14L22 21L39 14L22 7Z" fill="#B5E3FA" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M34 17V24H33.9C26.5 28.3 17.3 28.3 10 24V17" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M37 15V30" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M37 29C38.1 29 39 29.9 39 31C39 32.1 38.1 33 37 33C35.9 33 35 32.1 35 31C35 29.9 35.9 29 37 29Z" fill="#145797"/>
                                            <path d="M37.0001 37C35.5001 37 34.4001 35.6 34.9001 34.2L35.8001 31.1H38.2001L39.1001 34.2C39.6001 35.6 38.5001 37 37.0001 37Z" fill="#145797"/>
                                        </svg>
                                    </div>
                                    <div class="icon__ct-item-content">
                                        <div class="icon__ct-item-title">
                                            Обучение
                                        </div>
                                        <div class="icon__ct-item-text">
                                            Доступ на Образовательный портал
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sc__box-bl fadeIn animated">
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                            <div class="custom-text">
                                <h3>Возможности слушателя</h3>
                                <small>
                                    При работе в Системе электронной регистрации на обучение по ДПО, ПО, ЕМИАС в Государственном бюджетном профессиональном образовательном учреждении Департамента здравоохранения города Москвы «Медицинский колледж № 7» (далее – Система ЭР):
                                </small>
                                <ul>
                                    <li>
                                        Регистрация на платное обучение или обучение за счет бюджетных средств Правительства Москвы (по путевкам);
                                    </li>
                                    <li>
                                        Однократное создание личного кабинета с возможностью повторного прохождения регистрации в другие группы обучения;
                                    </li>
                                    <li>
                                        Электронный документооборот с сектором комплектования групп;
                                    </li>
                                    <li>
                                        Получение сведений (логин и пароль) для доступа на Образовательный портал ГБПОУ ДЗМ «МК № 7»;
                                    </li>
                                    <li>
                                        Просмотр сведений о расписании начала занятий, информации о готовности документов и иной информации отдела обеспечения образовательного процесса ДПО, ДО и ПО.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="sc__box-bl fadeIn animated">
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                            <div class="custom-content-section">
                                <div class="custom-text">
                                    <h3>Алгоритм работы в Системе ЭР</h3>
                                    <ul>
                                        <li>
                                            Заполнить или проверить правильность данных, указанных в профиле (фамилия, имя, отчество, иные данные) в разделе «Профиль».
                                        </li>
                                        <li>
                                            Изучить требования к предоставлению информации в Системе ЭР.
                                        </li>
                                        <li>
                                            В блоке «Заявки» - ввести номер группы и дату начала обучения, на которое производится регистрация.
                                        </li>
                                        <li>
                                            Добавить фотографии документов, нажать на кнопку «Отправить». Статус должен измениться на «Заявка отправлена». Если статус «Заявка формируется» - проверить соответствие документов требованиям Системы, подгрузить требуемые документы в отдельных файлах в формате JPEG (объём файла не более 5 МБ).
                                        </li>
                                        <li>
                                            Если специалист в настоящее время проверяет ваши документы, то ваша заявка будет иметь статус «Заявка у оператора».
                                        </li>
                                        <li>
                                            Когда специалист отдела проверит документы, может отправить вам информацию о добавлении дополнительных документов. Информация придет на вашу электронную почту и отобразится в личном кабинете (статус – «Дополнить документы»). После добавления нужного документа нажмите «Отправить», статус заявки измениться на «Заявка отправлена».
                                        </li>
                                        <li>
                                            Если документация соответствует требованиям, специалист вас зарегистрирует в Системе и отправит вам для подписи в электронном виде карточку слушателя. Вам придет на почту сообщение, а в Личном кабинете статус заявки изменится на «Требуется подписать карточку», ее необходимо «подписать» в окне Личного кабинета.
                                        </li>
                                        <li>
                                            После подписания карточки в разделе «Обучение» вам придет логин и пароль для входа на Образовательный портал, а сама заявка на обучение станет неактивным полем в окне «Заявки» и будет иметь статус «Зарегистрирован», что говорит об успешной регистрации на обучение.
                                        </li>
                                        <li>
                                            В случае отказа в зачислении вам придет уведомление на почту, а в Личном кабинете статус заявки изменится на «Отказано в регистрации».
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="custom-content-section">
                                <div class="custom-text">
                                    <p>
                                        Информационная поддержка слушателей: <br>
                                        qdpo@medcollege7.ru <br>
                                        +7 (495) 339-47-88
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



