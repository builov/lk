<?php


namespace backend\models;

use common\models\Message;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\base\ErrorException;

/**
 * Register Form
 */

class SendEmailForm extends Model
{
    public $message_id;
    public $uid;
    public $message_code;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
                    [['message_id', 'uid', 'message_code'], 'required'],
                    [['message_code'], 'string'],
                    [['message_id', 'uid'], 'integer'],
                ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'message_id' => 'Сообщение',
            'uid' => 'Пользователь',
            'message_code' => 'Код сообщения',
        ];
    }


//    /**
//     *
//     * @param User $user user model to with email should be send
//     * @return bool whether the email was sent
//     */
//    protected function sendEmail($user)
//    {
//        return Yii::$app
//            ->mailer
//            ->compose(
//                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
//                ['user' => $user]
//            )
//            ->setFrom([Yii::$app->params['supportEmail'] => 'Приемная комиссия ГБПОУ ДЗМ «МК №7»'])
//            ->setTo($this->email)
//            ->setSubject('Личный кабинет абитуриента. Подтверждение регистрации.')
//            ->send();
//    }

}



