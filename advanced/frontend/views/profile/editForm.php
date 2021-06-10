<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\RegisterFormStepOne */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Profile;
use yii\widgets\Breadcrumbs;

//print_r($model);

$this->title = 'Редактирование профиля';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="">

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Личный кабинет', 'url' => '/profile'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>


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
            ]);

            $model->birthdate = date("d.m.Y", strtotime($model->birthdate));
            $model->passport_date = date("d.m.Y", strtotime($model->passport_date));

            echo '<pre>';
            print_r($model);
            echo '</pre>';

            ?>

            <fieldset>
                <legend>Личные данные</legend>

                <?= $form->field($model, 'lastname')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'firstname')->textInput() ?>

                <?= $form->field($model, 'patronim')->textInput() ?>

                <!--                --><?//= $form->field($model, 'birthdate')->textInput(['type' => 'date']) ?>
                <?= $form->field($model, 'birthdate')->textInput()->hint('В формате дд-мм-гггг') ?>


                <?= $form->field($model, 'gender')->radioList(Profile::_GENDER); ?>

                <?= $form->field($model, 'citizenship')->dropDownList(Profile::_CITIZENSHIP) ?>

                <?= $form->field($model, 'snils')->textInput() ?>


            </fieldset>

            <fieldset>
                <legend>Образование</legend>

                <?= $form->field($model, 'education_level')->dropDownList(Profile::_EDUCATION) ?>

                <?= $form->field($model, 'institution')->textInput() ?>

                <?= $form->field($model, 'graduate_year')->textInput(['maxlength' => 4]) ?>

                <label class="control-label" for="registerform-certificate_series">Серия и номер документа об образовании</label>

                <?= $form->field($model, 'certificate_series')->textInput()->label(false) ?>

                <?= $form->field($model, 'certificate_number')->textInput()->label(false) ?>
            </fieldset>

            <fieldset>
                <legend>Паспорт</legend>

                <label class="control-label" for="registerform-passport_series">Серия и номер паспорта</label>

                <?= $form->field($model, 'passport_series')->textInput(['class' => 'form-control class1'])->label(false) ?>

                <?= $form->field($model, 'passport_number')->textInput(['class' => 'form-control class2'])->label(false) ?>

                <?= $form->field($model, 'passport_issued')->textarea(['rows' => 2, 'cols' => 5]) ?>

                <?= $form->field($model, 'passport_code')->textInput() ?>

                <?= $form->field($model, 'passport_date')->textInput()->hint('В формате дд-мм-гггг') ?>
            </fieldset>

            <fieldset>
                <legend>Контактные данные</legend>

                <?php $option[0] = ''; $region_options = $option + Profile::_REGION; ?>
                <?= $form->field($model, 'region')->dropDownList($region_options) ?>

                <?= $form->field($model, 'phone')->textInput() ?>

                    <?= $form->field($model, 'address_passport')->textarea(['rows' => 2, 'cols' => 5]) ?>

                    <?= $form->field($model, 'address_current')->textarea(['rows' => 2, 'cols' => 5]) ?>

            </fieldset>

            <?= $form->field($model, 'agree')->checkbox([
                'label' => 'Я подтверждаю истинность указанных данных',
                'labelOptions' => [
                    'style' => 'visibility:visible;'
                ],
                'disabled' => false,
                'checked' => false
            ]) ?>



            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-lg-4">



        </div>
    </div>
</div>
