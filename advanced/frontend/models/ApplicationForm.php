<?php

//https://p0vidl0.info/yii2-api-guides/guide-ru-input-file-upload.html

namespace frontend\models;

use common\models\Application;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ApplicationForm extends Model
{
    /**
     * @var UploadedFile[]
     */
//    public $imageFiles;
//    public $id;
//    public $uid;
    public $program_id;
//    public $status;
//    public $created;
//    public $edited;

    public function rules()
    {
        return [
//            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 10],
            [['program_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'program_id' => 'Программа обучения',
        ];
    }

    public function filesCheck()
    {
        exit();
    }

    public function createApplication()
    {
        $model = new Application();

        $model->uid = Yii::$app->user->id;
        $model->program_id = $this->program_id;
        $model->status = 1;
        $model->created = time();
        $model->updated = time();

        return $model->save();
    }

    public function upload()
    {
        if ($this->validate()) //Заявка на обучение по этой программе уже отправлена
        {
            //сохранение на диск
            foreach ($this->imageFiles as $file)
            {
                $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
            }

            //todo: сохранение записи в БД: таблица Files

            return true;
        }
        else {
            return false;
        }
    }
}