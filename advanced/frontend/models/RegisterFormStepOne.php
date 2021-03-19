<?php


namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Register Form Step 1
 */
class RegisterFormStepOne extends Model
{
    public $lastname;
    public $firstname;
    public $patronim;
    public $birthdate;
    public $snils;
    public $gender;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            // 'message'=>'Please enter a value for {attribute}.'
            [['lastname', 'firstname', 'patronim', 'birthdate', 'snils', 'gender'], 'required', 'message'=>'Обязательное поле'],
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
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
//    public function validatePassword($attribute, $params)
//    {
//        if (!$this->hasErrors()) {
//            $user = $this->getUser();
//            if (!$user || !$user->validatePassword($this->password)) {
//                $this->addError($attribute, 'Incorrect username or password.');
//            }
//        }
//    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
//    public function login()
//    {
//        if ($this->validate()) {
//            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
//        }
//
//        return false;
//    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
//    protected function getUser()
//    {
//        if ($this->_user === null) {
//            $this->_user = User::findByUsername($this->username);
//        }
//
//        return $this->_user;
//    }
}
