<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "application".
 *
 * @property int $id
 * @property int|null $uid
 * @property int|null $program_id
 * @property int|null $status
 * @property int|null $created
 * @property int|null $updated
 * @property int|null $show_message
 *
 * @property User $u
 * @property Comment[] $comments
 */
class Application extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_IN_PROCESS = 2;
    const STATUS_ACCEPTED = 3;
    const STATUS_DECLINED = 4;
    const STATUSES = [
        '1' => 'новая', // еще не передано в 1С
        '2' => 'на рассмотрении', //1С: подано
        '3' => 'принята', //1С: получено
        '4' => 'отклонена', //1С: отказано
        '5' => 'отозвана абитуриентом' //1С: отозвано
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'program_id', 'status', 'created', 'updated', 'show_message'], 'integer'],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['uid' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'program_id' => 'Program ID',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
            'show_message' => 'Show Message',
        ];
    }


    public function getDeclineMessages()
    {
        $declide_codes = array('1030','1080.91С','1080.4');
        $messages = Message::find()->where(['in','code', $declide_codes])->andWhere(['uid' => $this->uid])->all();

        return $messages;
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['appl_id' => 'id']);
    }

    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['appl_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }

    public function getProgram()
    {
        return $this->hasOne(Program::className(), ['id' => 'program_id']);
    }
}
