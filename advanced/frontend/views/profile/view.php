<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
//use yii\jui\DatePicker;
use common\models\Profile;
use common\models\Program;

//print_r($model);

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row">
        <div class="col-lg-8">

            <h2>Заявки на обучение</h2>

<!--            <h3>Доступные программы</h3>-->
<!--            В зависимости от региона и уровня образования-->

<!--            <pre>-->
<!--                --><?php //print_r($model->getAvailablePrograms()); ?>
<!--            </pre>-->

            <?php
            //todo сделать список только доступных данному пользователю программ
//            $fields = Program::find()->select('id, name')->asArray()->all();
//            foreach ($fields as $value) $options[$value['id']] = $value['name'];
            ?>

            <?php $form = ActiveForm::begin([
                    'id' => 'application-form',
                    'options' => ['enctype' => 'multipart/form-data']
            ]) ?>

            <?= $form->field($appform, 'program_id')->dropDownList($model->getAvailablePrograms()) ?>

            <p>Список документов:</p>
            <ul>
                <li>паспорт (страница с фото, страница с пропиской)</li>
                <li>временная регистрация (при наличии)</li>
                <li>документы об образовании (включая приложение с оценками с двух сторон)</li>
            </ul>

<!--            --><?//= $form->field($appform, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label(false) ?>

            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>

            <p>Перед отправкой убедитесь, что все необходимые документы загружены.</p>

            <?php ActiveForm::end() ?>

<?php //todo Вариант решения - отдельная форма для файлов. Файлы просто загружаются асинхронно для текущего uid, независимо от формы заявки. ?>

            <div id="image-container"></div>

            <?php $form2 = ActiveForm::begin([
                    'id' => 'upload-form',
                    'action' => '/profile/upload-file',
                    'options' => ['enctype' => 'multipart/form-data'],
            ]) ?>

            <?= $form2->field($file_form, 'imageFile')->fileInput()->label(false) ?>

            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>

            <?php ActiveForm::end() ?>















            <hr>

            <h2>Профиль</h2>

            <h3>Личные данные</h3>

            <p>Фамилия: <?= $model->profile->lastname ?></p>

            <p>Имя: <?= $model->profile->firstname ?></p>

            <p>Отчество: <?= $model->profile->patronim ?></p>

            <p>Дата рождение: <?= $model->profile->birthdate ?></p>

            <p>СНИЛС: <?= $model->profile->snils ?></p>

            <p>Пол: <?= Profile::_GENDER[$model->profile->gender] ?></p>


            <h3>Контактные данные</h3>

            <p>Регион: <?= Profile::_REGION[$model->profile->region] ?></p>

            <p>Адрес (по паспорту): <?= $model->profile->address_passport ?></p>

            <p>Адрес фактический: <?= $model->profile->address_current ?></p>

            <p>Индекс: <?= $model->profile->zip ?></p>

            <p>Телефон: <?= $model->profile->phone ?></p>

            <p>Адрес электронной почты: <?= $model->email ?></p>


            <h3>Образование</h3>

            <p>Уровень образования: <?= Profile::_EDUCATION[$model->profile->education_level] ?></p>

            <p>Название учебного заведения: <?= $model->profile->institution ?></p>

            <p>Дата окончания: <?= $model->profile->graduate_year ?></p>


            <h3>Паспорт</h3>

            <p>Серия и номер паспорта: <?= $model->profile->passport_series ?> <?= $model->profile->passport_number ?></p>

            <p>Кем выдан: <?= $model->profile->passport_issued ?></p>

            <p>Код подразделения: <?= $model->profile->passport_code ?></p>

            <p>дата выдачи: <?= $model->profile->passport_date ?></p>


            <h3>Смена пароля</h3>


        </div>
        <div class="col-lg-4">

            <h2>Обучение</h2>

            <p><strong><?= $model->profile->lastname ?> <?= $model->profile->firstname ?> <?= $model->profile->patronim ?></strong></p>

            <p>В настоящее время Вы не зарегистрированы на обучение в ГБПОУ ДЗМ «МК №7»</p>

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


