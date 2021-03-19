<?php


namespace frontend\models;


use yii\base\Model;
use yii\web\UploadedFile;

class FileForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload()
    {
        if ($this->validate())
        {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        }
        else {
            return false;
        }
    }


    private function randomFileName($extension = false)
    {
        $extension = $extension ? '.' . $extension : '';
        do {
            $name = md5(microtime() . rand(0, 1000));
            $file = $name . $extension;
        } while (file_exists($file));
        return $file;
    }
}