<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    public $fio;
    public $password_raw;
    public $passport_files;
    public $education_files;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['uid' => 'id']);
    }

    public function getFiles()
    {
        return $this->hasMany(Files::className(), ['uid' => 'id']);
    }

    public function getApplications()
    {
        return $this->hasMany(Application::className(), ['uid' => 'id']);
    }

//    /**
//     * @return array of id => name
//     */
    public function getAvailablePrograms_____() //с учетом отправленных заявок
    {
        $programs = Program::find()->select('id, name, base, region')->asArray()->all();
        $education_level = ($this->profile->education_level > 2) ? 2 : $this->profile->education_level;
        $options = [];

        $sent_programs = [];
        foreach ($this->applications as $application)
        {
            if ($application->status != Application::STATUS_DECLINED) $sent_programs[] = $application->program_id; //если статус 1,2,3
        }

        foreach ($programs as $program)
        {
//            $value['base'] = ($value['base'] > 2) ? 2 : $value['base']; //более высокие ступени образования = 11 кл.
            if ($program['base']==$education_level
                && in_array($this->profile->region, explode(",", $program['region'])))
            {
                if (!in_array($program['id'], $sent_programs)) $options[$program['id']] = $program['name'];
            }
        }
//        print_r($options);
//        $this->profile->region;
//        $this->profile->education_level;
        return $options;
    }

    public function getAvailablePrograms()  //без учета отправленных заявок
    {
        $programs = Program::find()->select('id, name, base, region')->asArray()->all();
        $education_level = ($this->profile->education_level > 2) ? 2 : $this->profile->education_level;
        $options = [];

        foreach ($programs as $program)
        {
            if ($program['base']==$education_level
                && in_array($this->profile->region, explode(",", $program['region'])))
            {
                $options[$program['id']] = $program['name'];
            }
        }
        return $options;
    }

    public function getSentApplications()
    {
        $programs = [];
        if ($appl = Application::find()->where(['uid' => $this->id])->all())
        {
            foreach ($appl as $a)
            {
                $programs[$a->program->id] = [$a->program->name, $a->status, $a->comments];
            }
        }
        return $programs;
    }
}
