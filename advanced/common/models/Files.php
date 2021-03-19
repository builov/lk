<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property int|null $uid
 * @property string|null $path
 * @property string|null $name
 * @property int|null $sizex
 * @property int|null $sizey
 * @property string|null $mime
 * @property int|null $weight
 * @property int|null $created
 *
 * @property User $u
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'sizex', 'sizey', 'weight', 'created'], 'integer'],
            [['path', 'name', 'mime'], 'string', 'max' => 255],
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
            'path' => 'Path',
            'name' => 'Name',
            'sizex' => 'Sizex',
            'sizey' => 'Sizey',
            'mime' => 'Mime',
            'weight' => 'Weight',
            'created' => 'Created',
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
