<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = 'Заявка';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="">

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Личный кабинет', 'url' => '/profile'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <h1>Заявка на обучение по программе «<?= $model->program->name ?>»</h1>


    <div class="row">
        <div class="col-lg-8">

            <?php
                echo '<pre>';
                print_r($model);
                echo '</pre>';
            ?>

        </div>
        <div class="col-lg-4">

        </div>
    </div>
</div>