<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int|null $appl_id
 * @property string|null $body
 * @property int|null $created
 *
 * @property Application $appl
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['appl_id', 'created'], 'integer'],
            [['body'], 'string'],
            [['appl_id'], 'exist', 'skipOnError' => true, 'targetClass' => Application::className(), 'targetAttribute' => ['appl_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'appl_id' => 'Appl ID',
            'body' => 'Body',
            'created' => 'Created',
        ];
    }

    /**
     * Gets query for [[Appl]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAppl()
    {
        return $this->hasOne(Application::className(), ['id' => 'appl_id']);
    }
}
