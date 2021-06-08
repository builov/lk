<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "message_template".
 *
 * @property int $id
 * @property string $code
 * @property string|null $body
 * @property string|null $template
 */
class MessageTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['body', 'template'], 'string'],
            [['code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'body' => 'Body',
            'template' => 'Template',
        ];
    }
}
