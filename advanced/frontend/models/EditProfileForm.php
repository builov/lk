<?php


namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * This is the edit form class for model "Profile".
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
class EditProfileForm extends Model
{
    public $lastname;
    public $firstname;
    public $patronim;
    public $birthdate;
    public $snils;
    public $gender;
    public $education_level;
    public $institution;
    public $graduate_year;
    public $certificate_series;
    public $certificate_number;
    public $passport_series;
    public $passport_number;
    public $passport_issued;
    public $passport_code;
    public $passport_date;
    public $citizenship;
    public $region;
    public $address_passport;
    public $address_current;
    public $zip;
    public $phone;
    public $agree;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $current_year = (int) date("Y");
        return [
            [['lastname',
                'firstname',
                'institution',
                'phone',
                'passport_issued',
                'address_passport_street',
                'address_passport_building',
                'gender',
                'education_level',
                'graduate_year',
                'birthdate',
                'passport_date',
                'citizenship',
                'agree'], 'required', 'message' => 'Обязательное поле'],
            [['birthdate', 'passport_date'], 'date', 'format'=>'dd-mm-yyyy'],
            [['gender',
                'education_level',
                'passport_number',
                'region',
                'citizenship',
                'agree'], 'integer'],
            [['graduate_year'], 'number', 'min' => 1950, 'max' => $current_year],
            [['passport_issued',
                'address_passport',
                'address_current'], 'string'],
            [['lastname',
                'firstname',
                'patronim',
                'snils',
                'institution',
                'passport_series',
                'passport_code',
                'phone',
                'certificate_series',
                'certificate_number'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'lastname' => 'Фамилия',
            'firstname' => 'Имя',
            'patronim' => 'Отчество',
            'birthdate' => 'Дата рождения',
            'snils' => 'СНИЛС',
            'gender' => 'Пол',
            'education_level' => 'Уровень образования',
            'institution' => 'Название учебного заведения',
            'graduate_year' => 'Год окончания',
            'certificate_series' => 'Серия документа об образовании',
            'certificate_number' => 'Номер документа об образовании',
            'passport_series' => 'Серия паспорта',
            'passport_number' => 'Номер паспорта',
            'passport_issued' => 'Кем выдан',
            'passport_code' => 'Код подразделения',
            'passport_date' => 'Дата выдачи',
            'citizenship' => 'Гражданство',
            'region' => 'Регион РФ',
            'address_passport' => 'Адрес регистрации по месту жительства (по паспорту)',
            'address_current' => 'Адрес по месту пребывания в г. Москве или Московской области',
            'zip' => 'Почтовый индекс',
            'phone' => 'Телефон',
            'agree' => 'Я подтверждаю истинность указанных данных',
        ];
    }

    public function init()
    {
        parent::init();

        $user = User::find(Yii::$app->user->id)->one();
        $profile = $user->profile;

        foreach ($this as $key => $value)
        {
            if ($key=='citizenship') continue;
            $this->$key = $profile->$key;
        }
        $this->citizenship = ($profile->region==4) ? 2 : 1;
        $this->agree = 0;
        $this->birthdate = implode('-', array_reverse(explode( '-', $this->birthdate)));
        $this->passport_date = implode('-', array_reverse(explode( '-', $this->passport_date)));
//        $this->region = '';






//        $this->lastname = $profile->lastname;
//        $this->firstname;
//        $this->patronim;
//        $this->birthdate;
//        $this->snils;
//        $this->gender;
//        $this->education_level;
//        $this->institution;
//        $this->graduate_year;
//        $this->certificate_series;
//        $this->certificate_number;
//        $this->passport_series;
//        $this->passport_number;
//        $this->passport_issued;
//        $this->passport_code;
//        $this->passport_date;
//        $this->citizenship;
//        $this->region;
//        $this->address_passport;
//        $this->address_current;
//        $this->zip;
//        $this->phone;
//        $this->agree;
    }


}