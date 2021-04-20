<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property int $uid
 * @property string|null $lastname
 * @property string|null $firstname
 * @property string|null $patronim
 * @property string|null $birthdate
 * @property string|null $snils
 * @property int|null $gender
 * @property int|null $education_level
 * @property string|null $institution
 * @property int|null $graduate_year
 * @property string|null $passport_series
 * @property string|null $passport_number
 * @property string|null $passport_issued
 * @property string|null $passport_code
 * @property string|null $passport_date
 * @property int|null $region
 * @property string|null $address_passport
 * @property string|null $address_current
 * @property int|null $zip
 * @property string|null $phone
 * @property int|null $agree
 * @property int|null $created
 * @property int|null $updated
 * @property int|null $status
 * @property string|null $certificate_series
 * @property string|null $certificate_number
 */
class Profile extends \yii\db\ActiveRecord
{
    const _EDUCATION = [
        1 => 'Основное общее (9 классов)',
        2 => 'Среднее общее (11 классов)',
        3 => 'Среднее (полное) общее образование',
        4 => 'Среднее профессиональное образование',
        5 => 'Начальное профессиональное образование'
    ];
    const _GENDER = [1 => 'Женский', 2 => 'Мужской'];
    const _REGION = [1 => 'г. Москва', 2 => 'Московская область', 3 => 'Другой субъект РФ']; //регион 4 это иностранец
    const _CITIZENSHIP = [1 => 'Российская Федерация', 2 => 'Другое'];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['birthdate', 'passport_date'], 'safe'],
            [['gender', 'education_level', 'graduate_year', 'region', 'zip', 'agree', 'created', 'updated', 'status'], 'integer'],
            [['passport_issued', 'address_passport', 'address_current'], 'string'],
            [['lastname', 'firstname', 'patronim', 'snils', 'institution', 'passport_series', 'passport_number', 'passport_code', 'phone', 'certificate_series', 'certificate_number'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'lastname' => 'Lastname',
            'firstname' => 'Firstname',
            'patronim' => 'Patronim',
            'birthdate' => 'Birthdate',
            'snils' => 'Snils',
            'gender' => 'Gender',
            'education_level' => 'Education Level',
            'institution' => 'Institution',
            'graduate_year' => 'Graduate Year',
            'passport_series' => 'Passport Series',
            'passport_number' => 'Passport Number',
            'passport_issued' => 'Passport Issued',
            'passport_code' => 'Passport Code',
            'passport_date' => 'Passport Date',
            'region' => 'Region',
            'address_passport' => 'Address Passport',
            'address_current' => 'Address Current',
            'zip' => 'Zip',
            'phone' => 'Phone',
            'agree' => 'Agree',
            'created' => 'Created',
            'updated' => 'Updated',
            'status' => 'Status',
            'certificate_series' => 'Certificate Series',
            'certificate_number' => 'Certificate Number',
        ];
    }
}
