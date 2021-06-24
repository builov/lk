<?php

use common\models\Application;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
//use yii\jui\DatePicker;
//use common\models\Profile;
//use common\models\Program;
use yii\widgets\Breadcrumbs;
use yii\widgets\Pjax;

//print_r($model->education_files);

$this->title = 'Заявка на обучение';
//$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .form__group-dz { /* reset */
        cursor: auto;
    }
    .image-container {
        padding-bottom: 1em;
    }
    .img-uploaded {
        width: 170px;
        height: 130px;
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        display: inline-block;
        margin-bottom: 1em;
        margin-right: 1em;
        border: 1px solid rgba(31, 31, 31, 0.2);
        border-radius: 5px;
        position:relative;
    }
    .img-uploaded a.delete-file {
        position:absolute;
        right:0;
        bottom:-1.5em;
        /*font-size:80%;*/

        font-size: 12px;
        line-height: 16px;
        cursor: pointer;
        text-align: right;
        color: #F44336;
    }
    .field-fileform-imagefile .help-block {
        font-size: 14px;
        line-height: 20px;
        color: rgba(31, 31, 31, 0.6);
        margin-top: 1em;
    }
    .xhr-message {
        color:#F44336;
    }
    ._breadcrumbs {
        margin-bottom:1.5em;
    }
    /*#education ul {*/
    /*    list-style-type:none;*/
    /*}*/
    /*#education ul li {*/
    /*    margin-bottom:.8em;*/
    /*}*/
</style>


<div class="section sc__lk sc__lk-profile sides">
    <div class="container">

        <div class="row">
            <div class="col-12 _breadcrumbs">
                <!--            --><?//= Breadcrumbs::widget([
                //                'homeLink' => ['label' => 'Личный кабинет', 'url' => '/profile'],
                //                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                //            ]) ?>

                <a href="/profile">Личный кабинет</a> &#8594; <?= $this->title ?>
            </div>
        </div>


        <div class="sc__lk-content">
            <div class="row">

                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 active">
                    <div data-parent="orders" class="sc__box-header toggle__mb-content active">
                        <div class="sc__box-title seo__item">
                            <?= $this->title ?>
                        </div>
                    </div>
                    <div id="orders" class="ct__box ct__box-orders mb-content" style="display: block;">
                        <div class="order__list">




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
<!--                                    <div id="drop-box-1" class="form__group form__group-disabled form__group-dz dz-field">-->
<!--                                        <div class="dz__default-wrap d-flex justify-content-center">-->
<!--                                            <div class="dz__default d-flex align-items-center">-->
<!--                                                <div class="icon__dz">-->
<!--                                                    <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">-->
<!--                                                        <path d="M12 39H32C33.1 39 34 38.1 34 37V13H29C27.9 13 27 12.1 27 11V5H12C10.9 5 10 5.9 10 7V37C10 38.1 10.9 39 12 39Z" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>-->
<!--                                                        <path d="M34 13L27 5" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>-->
<!--                                                        <path d="M21 9H14V14H21V9Z" fill="#B4E3FA" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>-->
<!--                                                        <path d="M14 19H30" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>-->
<!--                                                        <path d="M14 23H30" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>-->
<!--                                                        <path d="M14 27H30" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>-->
<!--                                                        <path d="M14 31H22" stroke="#145797" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>-->
<!--                                                    </svg>-->
<!--                                                </div>-->
<!--                                                <div class="dz__default-title">-->
<!--                                                    Загрузите файлы в в формате .jpg-->
<!--                                                </div>-->


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
<!--                                                            <a target="_blank" href="/uploads/--><?//= $file['name'] ?><!--">-->
                                                                    <div class="img-uploaded" style="background-image: url('/uploads/<?= $file['name'] . '?' . time() ?>')" >&nbsp;
                                                                        <?php if ($editable): ?>
                                                                            <a class="delete-file" href="/delete-file/<?= $file['id'] ?>">
                                                                                удалить
                                                                            </a>
                                                                        <?php endif; ?>
                                                                    </div>
<!--                                                            </a>-->
                                                                <?php endforeach;?>
                                                            <?php endif; ?>
                                                        </div>

<!--                                                        --><?php //if (isset($model->passport_files) && count($model->passport_files)<10): ?>
                                                        <?= $form2->field($file_form, 'imageFile')->fileInput()->label(false)
                                                            ->hint('Принимаются файлы в формате .jpg и .png размером не более 6000x6000 px.<br>Количество файлов &mdash; не более 10.') ?>
<!--                                                        --><?php //endif; ?>

                                                        <div class="xhr-message"></div>
                                                    <?php ActiveForm::end() ?>
                                                <?php Pjax::end(); ?>

<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
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


                        </div>
                    </div>
                </div>








                <div class="col-xl-4 col-lg-4 col-lg-4 col-md-12 col-sm-12 col-12 side-right">

                    <?php if (count($sent_applications[0]) > 0): ?>

                        <div data-parent="education" class="sc__box-header toggle__mb-content">
                            <div class="sc__box-title seo__item">
                                Отправленные заявки
                            </div>
                        </div>
                        <div id="education" class="ct__box ct__box-card mb-content">
                            <div class="custom-text text">

                                <ul>
                                    <?php foreach($sent_applications[0] as $prog_id => $program): ?>
                                        <li>
                                            <?= $program[0] ?>
                                            <div style="display: inline;" class="status status-color-<?= Application::COLORS[$program[1]] ?>">
                                                <?= \common\models\Application::STATUSES[$program[1]] ?>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>

                    <?php endif; ?>




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

                </div>
            </div>
        </div>
    </div>
</div>
































