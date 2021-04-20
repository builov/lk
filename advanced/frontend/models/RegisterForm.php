<?php


namespace frontend\models;

use common\models\Profile;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\base\ErrorException;

/**
 * Register Form
 */
class RegisterForm extends Model
{
    public $lastname;
    public $firstname;
    public $patronim;
    public $birthdate;
    public $snils;
//    public $snils2;
    public $gender;
    public $education_level;
    public $institution;
    public $graduate_year;
    public $certificate_series;
    public $certificate_number;
//    public $certificate_series_number;
    public $passport_series;
    public $passport_number;
//    public $passport_series_number;
    public $passport_issued;
    public $passport_code;
    public $passport_date;
    public $citizenship;
    public $region;
//    public $address_passport_region;
//    public $address_passport_city;
    public $address_passport_street;
    public $address_passport_building;
    public $address_passport_apartment;
//    public $address_current_region;
//    public $address_current_city;
    public $address_current_street;
    public $address_current_building;
    public $address_current_apartment;
//    public $zip;
    public $phone;
    public $email;
    public $agree;
    public $addresses_coincide;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $current_year = (int) date("Y");
        return [
            // 'message'=>'Please enter a value for {attribute}.'
            [['lastname',
                'firstname',
                'institution',
                'phone',
                'email',
                'passport_issued',
                'address_passport_street',
                'address_passport_building',
                'gender',
                'education_level',
                'graduate_year',
                'agree',
                'birthdate',
                'passport_date'],
                'required',
                'message' => 'Обязательное поле'],
//            [['passport_series', 'passport_number', 'passport_code', 'region', 'snils', 'certificate_series', 'certificate_number'],
//                'required', 'when' => function() {
//                    return $this->citizenship == 1;
//            }],
//            [['passport_series_number', 'certificate_series_number'],
//                'required', 'when' => function() {
//                return $this->citizenship == 2;
//            }],
            [['birthdate', 'passport_date'], 'date', 'format'=>'dd-mm-yyyy'],
//            [['birthdate', 'passport_date'], 'string'],
            [['gender',
                'education_level',
                'passport_number',
                'agree',
                'region',
                'citizenship'], 'integer'],
            [['graduate_year'], 'number', 'min' => 1950, 'max' => $current_year],
            [['passport_issued',
                'address_passport_street',
                'address_passport_building',
                'address_passport_apartment',
                'address_current_street',
                'address_current_building',
                'address_current_apartment'], 'string'],
            [['lastname',
                'firstname',
                'patronim',
                'snils',
                'institution',
                'passport_series',
                'passport_code',
                'phone',
                'email',
                'certificate_series',
                'certificate_number'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
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
//            'certificate_series_number' => 'Серия и номер документа об образовании',
            'passport_series' => 'Серия паспорта',
            'passport_number' => 'Номер паспорта',
//            'passport_series_number' => 'Серия и номер паспорта',
            'passport_issued' => 'Кем выдан',
            'passport_code' => 'Код подразделения',
            'passport_date' => 'Дата выдачи',
            'citizenship' => 'Гражданство',
            'region' => 'Регион РФ',
//            'address_passport' => 'Адрес (как в паспорте)',
//            'address_current' => 'Фактический адрес проживания',
//            'address_passport_region' => 'Регион (Субъект РФ для граждан РФ)',
//            'address_passport_city' => 'Город',
            'address_passport_street' => 'Регион/Район/Город/Улица',
            'address_passport_building' => 'Дом/Корпус/Строение',
            'address_passport_apartment' => 'Квартира (если есть)',
//            'address_current_region' => 'Субъект РФ',
//            'address_current_city' => 'Город',
            'address_current_street' => 'Регион/Район/Город/Улица',
            'address_current_building' => 'Дом/Корпус/Строение',
            'address_current_apartment' => 'Квартира (если есть)',
//            'zip' => 'Почтовый индекс',
            'phone' => 'Телефон',
            'email' => 'Электронная почта',
//            'agree' => 'Я подтверждаю согласие на обработку персональных данных',
        ];
    }



    public function registerUser()
    {
        if (!$this->validate())
        {
//            Сделать обработку ошибок:
//            1. такой email уже существует
//                Error Info: Array
//                (
//                    [0] => 23000
//                    [1] => 1062
//                    [2] => Duplicate entry 'mail1@mail.ru' for key 'username'
//                )

            return null;
        }

        try {
            $user = new User();
            $user->username = str_replace(' ', '', $this->email);
            $user->email = str_replace(' ', '', $this->email);
            $user->password_raw = Yii::$app->security->generateRandomString(10);
            $user->setPassword($user->password_raw);
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();

            $user->fio = $this->lastname . ' ' . $this->firstname . ' ' . $this->patronim;

            if ($this->sendEmail($user)) $user->save();
            else exit; //todo редирект на страницу с сообщением об ошибке
        }
        catch (\yii\db\Exception $e)
        {
//            print_r($e->errorInfo[1]);
            return 'error' . $e->errorInfo[1];
        }

//        if ($user->id && $this->createProfile($user->id) && $this->sendEmail($user))
        if ($user->id && $this->setProfile($user->id))
        {
            return $user->id;
        }
        else return false;
    }

    public function setProfile($uid)
    {
        $profile = new Profile();

        $profile->uid = (int) $uid;
        $profile->lastname = $this->lastname;
        $profile->firstname = $this->firstname;
        $profile->patronim = $this->patronim;

        //переформатирование дд-мм-гггг в гггг-мм-дд
        $profile->birthdate = implode('-', array_reverse(explode( '-', $this->birthdate)));

        $profile->snils = $this->snils;
        $profile->gender = (int) $this->gender;

        $profile->region = ($this->citizenship==1) ? $this->region : 4;

        $profile->education_level = (int) $this->education_level;
        $profile->institution = $this->institution;
        $profile->graduate_year = (int) $this->graduate_year;

        $profile->passport_series = $this->passport_series;
        $profile->passport_number = $this->passport_number;
        $profile->certificate_series = $this->certificate_series;
        $profile->certificate_number = $this->certificate_number;

        $profile->passport_issued = $this->passport_issued;
        $profile->passport_code = $this->passport_code;
        $profile->passport_date = implode('-', array_reverse(explode( '-', $this->passport_date)));

        $profile->address_passport = $this->address_passport_street . ', дом ' . $this->address_passport_building . ', квартира ' . $this->address_passport_apartment;
        $profile->address_current = $this->address_current_street . ', дом ' . $this->address_current_building . ', квартира ' . $this->address_current_apartment;
        $profile->zip = 0; //(int) $this->zip;
        $profile->phone = $this->phone;
        $profile->agree = (int) $this->agree;
        $profile->created = time();
//        $profile->updated
//        $profile->status

        return $profile->save();
    }


    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
//        echo '<pre>';
//        print_r($user);
//        echo '</pre>';

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => 'Приемная комиссия ГБПОУ ДЗМ «МК №7»'])
            ->setTo($this->email)
            ->setSubject('Личный кабинет абитуриента. Подтверждение регистрации.')
            ->send();
    }
}