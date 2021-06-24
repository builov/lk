<?php

//https://p0vidl0.info/yii2-api-guides/guide-ru-input-file-upload.html

namespace frontend\models;

use common\models\Application;
use common\models\Files;
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

    public function duplicationCheck()
    {
        $uid = Yii::$app->user->id;
        if ($applications = Application::find()->where(['uid' => $uid, 'program_id' => $this->program_id])->all())
            return true;

        $count = 0;
        foreach ($applications as $application) if ($application->status != Application::STATUS_DECLINED) $count++;
        if ((bool) $count)
        {
            Yii::$app->session->setFlash('error', 'Заявка на обучение по этой программе уже отправлена.');
            return false;
        }
        return true;
    }

    public function docsCheck()
    {
//          //проверка для версии с тремя типами док-тов
//        $uid = Yii::$app->user->id;
//        $files = Files::find()->where(['uid' => $uid])->asArray()->all();
//        $passport = 0;
//        $education = 0;
//        foreach ($files as $file)
//        {
//            if ($file['doctype'] == 1) $passport++;
//            elseif ($file['doctype'] == 2) $education++;
//        }
//
//        if ($passport < 2 || $education < 2)
//        {
//            Yii::$app->session->setFlash('error', 'Загрузите необходимые сканы документов:
//            <ul>
//                <li>паспорт: страница с фото, страница с пропиской (минимум 2 файла)</li>
//                <li>документы об образовании, включая приложение с оценками с двух сторон (минимум 2 файла)</li>
//            </ul>');
//            return false;
//        }
        return true;
    }

    public function createApplication()
    {
        $model = new Application();

        $model->uid = Yii::$app->user->id;
        $model->program_id = $this->program_id;
        $model->status = 1;
        $model->created = time();
        $model->updated = time();
        $model->show_message = 1;

        return $model->save();
    }

    public function upload()
    {
        if ($this->validate())
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