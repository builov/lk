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
 * @property int|null $doctype
 *
 * @property User $u
 */
class Files extends \yii\db\ActiveRecord
{
    const TYPES = [
        'passport' => [1,11],
        'education' => [2,22],
        'achievements' => [3,33]
    ];

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
            [['uid', 'sizex', 'sizey', 'weight', 'created', 'doctype'], 'integer'],
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
            'doctype' => 'Doctype',
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

    public function deleteFile()
    {
        $upload_dir = Yii::$app->params['uploadDir'] . DIRECTORY_SEPARATOR;
        $deleted_dir = $upload_dir . 'deleted' . DIRECTORY_SEPARATOR;

//        echo $upload_dir;
//        echo $deleted_dir;
//        exit;

        if ($this->delete())
        {
            try {
                rename($upload_dir . $this->name, $deleted_dir . $this->name);
            }
            catch (\ErrorException $e) {
                Yii::$app->session->setFlash('error', 'Ошибка выполнения rename()');
                return false;
            }

            return true;
        }
        return false;
    }
}
