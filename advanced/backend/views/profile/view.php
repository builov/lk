<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Profile */

$this->title = $model->uid;
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="profile-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->uid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->uid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'uid',
            'lastname',
            'firstname',
            'patronim',
            'birthdate',
            'snils',
            'gender',
            'education_level',
            'institution',
            'graduate_year',
            'passport_series',
            'passport_number',
            'passport_issued:ntext',
            'passport_code',
            'passport_date',
            'region',
            'address_passport:ntext',
            'address_current:ntext',
            'zip',
            'phone',
            'agree',
            'created',
            'updated',
            'status',
            'certificate_series',
            'certificate_number',
        ],
    ]) ?>

</div>
