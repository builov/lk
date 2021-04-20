<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Profiles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Profile', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'uid',
            'lastname',
            'firstname',
            'patronim',
            'birthdate',
            //'snils',
            //'gender',
            //'education_level',
            //'institution',
            //'graduate_year',
            //'passport_series',
            //'passport_number',
            //'passport_issued:ntext',
            //'passport_code',
            //'passport_date',
            //'region',
            //'address_passport:ntext',
            //'address_current:ntext',
            //'zip',
            //'phone',
            //'agree',
            //'created',
            //'updated',
            //'status',
            //'certificate_series',
            //'certificate_number',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
