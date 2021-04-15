<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property int|null $uid
 * @property int|null $type
 * @property string|null $body
 * @property int|null $created
 * @property int|null $updated
 * @property int|null $status
 * @property int|null $appl_id
 * @property int|null $date
 * @property string|null $code
 *
 * @property User $u
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'type', 'created', 'updated', 'status', 'appl_id', 'date'], 'integer'],
            [['body'], 'string'],
            [['code'], 'string', 'max' => 255],
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
            'type' => 'Type',
            'body' => 'Body',
            'created' => 'Created',
            'updated' => 'Updated',
            'status' => 'Status',
            'appl_id' => 'Appl ID',
            'date' => 'Date',
            'code' => 'Code',
        ];
    }

    /**
     * Gets query for [[U]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getU()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }
}
