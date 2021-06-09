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

<div class="">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php if (count($messages)): ?>
        <h3>Сообщения:</h3>
        <div class="message-area">
            <ul>
                <?php foreach ($messages as $message): ?>
                    <li>
                        <?= $message->getText() ?>
                        <?php $url = '/message/' . $message->id . '/dont-show'; ?>
                        <?= Html::a('Больше не показывать', [$url], ['class' => 'dont-show-message-button']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php Pjax::end(); ?>


    <div class="row">
        <div class="col-lg-8">

            <?php if (!count($sent_applications[0])): ?>

                <h2>Заявка на обучение</h2>

                <?php //$fields = Program::find()->select('id, name')->asArray()->all(); ?>

                <?php $form = ActiveForm::begin([
                'id' => 'application-form',
                'options' => ['enctype' => 'multipart/form-data']
            ]) ?>

                <?= $form->field($appform, 'program_id')->dropDownList($available_programs) ?>

                <p>Необходимые документы:</p>
                <ul>
                    <li>паспорт (страница с фото, страница с пропиской)</li>
                    <li>временная регистрация (при наличии)</li>
                    <li>документы об образовании (включая приложение с оценками с двух сторон)</li>
                </ul>
                <p>Перед отправкой убедитесь, что все необходимые документы загружены.</p>

                <?php ActiveForm::end() ?>

                <div style="margin-top: 3em;">
                    <?php $form2 = ActiveForm::begin([
                        'id' => 'upload-form-passport',
                        'action' => '/profile/upload-file',
                        'options' => ['enctype' => 'multipart/form-data','class' => 'upload-form'],
                        'enableClientValidation' => false,
                    ]) ?>

                    <fieldset>

                        <legend>Паспорт и Свидетельство о регистрации по месту пребывания</legend>

                        <?= $form2->field($file_form, 'doctype')->hiddenInput(['value'=>'1'])->label(false) ?>

                        <div class="image-container">
                            <?php if (is_array($model->passport_files)): ?>
                                <?php foreach ($model->passport_files as $file): ?>
                            <a target="_blank" href="/uploads/<?= $file['name'] ?>">
                                <div class="img-uploaded" style="background-image: url('/uploads/<?= $file['name'] . '?' . time() ?>')" >&nbsp;</div>
                            </a>
                                <?php endforeach; endif; ?>
                        </div>

                        <?= $form2->field($file_form, 'imageFile')->fileInput()->label(false)
                            ->hint('Только файлы в формате .jpg размером не более 5000x5000 px.') ?>

                        <div class="xhr-message"></div>

                        <!--                    --><?//= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>

                    </fieldset>

                    <?php ActiveForm::end() ?>
                </div>


                <div style="margin-top: 3em;">
                    <?php $form3 = ActiveForm::begin([
                        'id' => 'upload-form-education',
                        'action' => '/profile/upload-file',
                        'options' => ['enctype' => 'multipart/form-data','class' => 'upload-form'],
                        'enableClientValidation' => false,
                    ]) ?>

                    <fieldset>

                        <legend>Документы об образовании</legend>

                        <?= $form2->field($file_form, 'doctype')->hiddenInput(['value'=>'2'])->label(false) ?>

                        <div class="image-container">
                            <?php if (is_array($model->education_files)): ?>
                                <?php foreach ($model->education_files as $file): ?>
                            <a target="_blank" href="/uploads/<?= $file['name'] ?>">
                                    <div class="img-uploaded" style="background-image: url('/uploads/<?= $file['name'] . '?' . time() ?>')" >&nbsp;</div>
                                <?php endforeach; endif; ?>
                            </a>
                        </div>

                        <?= $form3->field($file_form, 'imageFile')->fileInput()->label(false)
                            ->hint('Только файлы в формате .jpg размером не более 5000x5000 px.') ?>

                        <div class="xhr-message"></div>

                        <!--                    --><?//= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>

                    </fieldset>

                    <?php ActiveForm::end() ?>
                </div>


                <div style="margin-top: 3em;">
                    <?php $form4 = ActiveForm::begin([
                        'id' => 'upload-form-achievements',
                        'action' => '/profile/upload-file',
                        'options' => ['enctype' => 'multipart/form-data','class' => 'upload-form'],
                        'enableClientValidation' => false,
                    ]) ?>

                    <fieldset>

                        <legend>
                            Личные достижения
<!--                            --><?php //if ($editable): ?><!--<a href="/delete-scan/achievements" class="delete-image"><span class="glyphicon glyphicon-trash"></span></a>--><?php //endif; ?>
                        </legend>

                        <?= $form4->field($file_form, 'doctype')->hiddenInput(['value'=>'3'])->label(false) ?>

                        <div class="image-container">
                            <?php if (is_array($model->achievements_files)): ?>
                                <?php foreach ($model->achievements_files as $file): ?>
                                    <a target="_blank" href="/uploads/<?= $file['name'] ?>">
                                        <div class="img-uploaded"
                                             style="background-image: url('/uploads/<?= $file['name'] . '?' . time() ?>')" >&nbsp;</div>
                                    </a>
                                <?php endforeach; endif; ?>
                        </div>

                        <?= $form4->field($file_form, 'imageFile')->fileInput()->label(false)
                            ->hint('Только файлы в формате .jpg размером не более 5000x5000 px.') ?>

                        <div class="xhr-message"></div>

                        <!--                    --><?//= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>

                    </fieldset>

                    <?php ActiveForm::end() ?>

                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>



            <?php else: ?>

                <h3>Отправленные заявки</h3>

                <ul>
                    <?php foreach($sent_applications[0] as $prog_id => $program): ?>
                        <li>
<!--                            <a href="/application/--><?//= $program[3] ?><!--">-->
                                <?= $program[0] ?>
<!--                            </a> -->
                            (<span class="status<?= $program[1] ?>"><?= Application::STATUSES[$program[1]] ?></span>)
                            <?php if ($program[1] == Application::STATUS_DECLINED): ?>


                                <div>Комментарий:</div>
                                <ul>
                                <?php foreach($program[2] as $comment): ?>
                                    <li><?= $comment->getText() ?> (<?= date('d.m.Y', $comment->created) ?>)</li>
                                <?php endforeach; ?>
                                </ul>



                                <div>Вы можете отправить заявку снова после устранения недостатков, указанных в комментарии.</div>
                                <div><?= Html::a('Отправить еще раз', ['profile/application/form'], ['class' => 'btn btn-primary']) ?></div>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>


                <?php if ((bool)(count($available_programs) - count($sent_applications[0]))): ?>
                    <p><?= Html::a('Новая заявка', ['profile/application/form'], ['class' => 'btn btn-primary']) ?></p>
                <?php endif; ?>

            <?php endif; ?>

            <hr>


            <h2>Профиль <?php if ($editable): ?><a href="/profile/edit"><span class="glyphicon glyphicon-pencil"></span></a><?php endif; ?></h2>

            <h3>Личные данные
<!--                <a href="/profile/edit"><span class="glyphicon glyphicon-pencil"></span></a>-->
            </h3>
            <p>Фамилия: <?= $model->profile->lastname ?></p>
            <p>Имя: <?= $model->profile->firstname ?></p>
            <p>Отчество: <?= $model->profile->patronim ?></p>
            <p>Дата рождение: <?= date("d-m-Y", strtotime($model->profile->birthdate)) ?></p>
            <p>СНИЛС: <?= $model->profile->snils ?></p>
            <p>Пол: <?= Profile::_GENDER[$model->profile->gender] ?></p>

            <h3>Контактные данные </h3>
<!--            <p>Регион: --><?//= Profile::_REGION[$model->profile->region] ?><!--</p>-->
            <p>Адрес (по паспорту): <?= $model->profile->address_passport ?></p>
            <p>Адрес фактический: <?= $model->profile->address_current ?></p>
<!--            <p>Индекс: --><?//= $model->profile->zip ?><!--</p>-->
            <p>Телефон: <?= $model->profile->phone ?></p>
            <p>Адрес электронной почты: <?= $model->email ?></p>

            <h3>Образование </h3>
            <p>Уровень образования: <?= Profile::_EDUCATION[$model->profile->education_level] ?></p>
            <p>Название учебного заведения: <?= $model->profile->institution ?></p>
            <p>Дата окончания: <?= $model->profile->graduate_year ?></p>
            <p>Серия и номер документа об образовании: <?= $model->profile->certificate_series ?> <?= $model->profile->certificate_number ?></p>

            <h3>Паспорт </h3>
            <p>Серия и номер паспорта: <?= $model->profile->passport_series ?> <?= $model->profile->passport_number ?></p>
            <p>Кем выдан: <?= $model->profile->passport_issued ?></p>
            <p>Код подразделения: <?= $model->profile->passport_code ?></p>
            <p>Дата выдачи: <?= date("d-m-Y", strtotime($model->profile->passport_date)) ?></p>

            <p>&nbsp;</p>
            <p><?= Html::a('Сменить пароль', ['/site/request-password-reset'], ['class' => 'btn btn-primary']) ?></p>


        </div>
        <div class="col-lg-4">

            <h2>Обучение</h2>

            <p><strong><?= $model->profile->lastname ?> <?= $model->profile->firstname ?> <?= $model->profile->patronim ?></strong></p>

            <?php
                $accepted = [];
                if (count($sent_applications[0])) foreach($sent_applications[0] as $prog_id => $program) if ($program[1]==3) $accepted[] = $program[0];
            ?>

            <?php if (count($accepted)): ?>
                <p>Вы зарегистрированы на обучение в ГБПОУ ДЗМ «МК №7» по программе:</p>
                <ul>
                    <?php foreach($accepted as $program): ?>
                        <li><?= $program ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>В настоящее время Вы не зарегистрированы на обучение в ГБПОУ ДЗМ «МК №7»</p>
            <?php endif; ?>



            <p>&nbsp;</p>
            <h2>О поступлении</h2>
            <p><a href="">Список документов для поступления</a></p>
            <p><a href="">Перечень медицинских противопоказаний для поступления на обучение</a></p>
            <p><a href="">Информация о необходимости прохождения предварительных медицинских осмотров (обследований)</a></p>
            <p><a href="">Условия приема на обучение по договорам</a></p>
            <p><a href="">Условия приема на обучение за счет ассигнований бюджета города Москвы</a></p>
            <p><a href="">Перечень вступительных испытаний для поступления на обучение</a></p>
        </div>
    </div>
</div>


