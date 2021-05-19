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
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="">

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Личный кабинет', 'url' => '/profile'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row">
        <div class="col-lg-8">

<!--            <h2>Заявка на обучение</h2>-->

            <?php
            $options = $available_programs;
            foreach ($available_programs as $program_id => $program_name) {
                if (array_key_exists($program_id, $sent_applications)
                    && $sent_applications[$program_id][1] != Application::STATUS_DECLINED)
                    unset($options[$program_id]);
            }
//            if (count($options)):
            ?>

            <?php //$fields = Program::find()->select('id, name')->asArray()->all(); ?>

            <?php $form = ActiveForm::begin([
                'id' => 'application-form',
                'options' => ['enctype' => 'multipart/form-data'],
//                'action' => '/profile',
            ]) ?>

            <?= $form->field($appform, 'program_id')->dropDownList($options) ?>

            <p>Необходимые документы:</p>
            <ul>
                <li>паспорт (страница с фото, страница с пропиской)</li>
                <li>временная регистрация (при наличии)</li>
                <li>документы об образовании (включая приложение с оценками с двух сторон)</li>
            </ul>
            <p>Перед отправкой убедитесь, что все необходимые документы загружены.</p>

            <?php ActiveForm::end() ?>

            <?php Pjax::begin(); ?>

            <div style="margin-top: 3em;">
                <?php $form2 = ActiveForm::begin([
                    'id' => 'upload-form-passport',
                    'action' => '/profile/upload-file',
                    'options' => ['enctype' => 'multipart/form-data','class' => 'upload-form'],
                    'enableClientValidation' => false,
                ]) ?>

                <fieldset>

                    <legend>
                        Паспорт и Свидетельство о регистрации по месту пребывания
                        <?php if ($editable): ?><a href="/delete-scan/passport" class="delete-image"><span class="glyphicon glyphicon-trash"></span></a><?php endif; ?>
                    </legend>

                    <?= $form2->field($file_form, 'doctype')->hiddenInput(['value'=>'1'])->label(false) ?>

                    <div class="image-container">
                        <?php if (is_array($model->passport_files)): ?>
                            <?php foreach ($model->passport_files as $file): ?>
                                <a target="_blank" href="/uploads/<?= $file['name'] ?>">
                                    <div class="img-uploaded"
                                         style="background-image: url('/uploads/<?= $file['name'] . '?' . time() ?>')" >&nbsp;</div>
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

                    <legend>
                        Документы об образовании
                        <?php if ($editable): ?><a href="/delete-scan/education" class="delete-image"><span class="glyphicon glyphicon-trash"></span></a><?php endif; ?>
                    </legend>

                    <?= $form2->field($file_form, 'doctype')->hiddenInput(['value'=>'2'])->label(false) ?>

                    <div class="image-container">
                        <?php if (is_array($model->education_files)): ?>
                            <?php foreach ($model->education_files as $file): ?>
                                <a target="_blank" href="/uploads/<?= $file['name'] ?>">
                                    <div class="img-uploaded"
                                         style="background-image: url('/uploads/<?= $file['name'] . '?' . time() ?>')" >&nbsp;</div>
                                </a>
                            <?php endforeach; endif; ?>
                    </div>

                    <?= $form3->field($file_form, 'imageFile')->fileInput()->label(false)
                        ->hint('Только файлы в формате .jpg размером не более 5000x5000 px.') ?>

                    <div class="xhr-message"></div>

                    <!--                    --><?//= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>

                </fieldset>

                <?php ActiveForm::end() ?>

                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
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
                        <?php if ($editable): ?><a href="/delete-scan/achievements" class="delete-image"><span class="glyphicon glyphicon-trash"></span></a><?php endif; ?>
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

            <?php Pjax::end(); ?>

        </div>
        <div class="col-lg-4">
            <?php if (count($sent_applications) > 0): ?>
                <h3>Отправленные заявки</h3>

                <ul>
                    <?php foreach($sent_applications as $prog_id => $program): ?>
                        <li><?= $program[0] ?> (<span class="status<?= $program[1] ?>"><?= \common\models\Application::STATUSES[$program[1]] ?></span>)</li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>


