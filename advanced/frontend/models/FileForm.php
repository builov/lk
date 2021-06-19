<?php


namespace frontend\models;


use common\models\Files;
use Imagick;
use MergePdf;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

//require_once("../../merge-pdf-files/MergePdf.class.php");

class FileForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $doctype;
    public $uploadedFile;
    public $convertedFile;

    public function rules()
    {
        return [
            [['imageFile'], 'image', 'skipOnEmpty' => true, 'extensions' => 'jpg, JPG, jpeg, png', 'maxWidth' => 6000, 'maxHeight' => 6000],
            [['doctype'], 'integer'],
        ];
    }

    public function upload()
    {
        if ($this->validate())
        {
            $uid = Yii::$app->user->id;
            $name = 'user' . $uid . '_' . $this->randomize();
            $upload_dir = Yii::$app->params['uploadDir'] . DIRECTORY_SEPARATOR;

            $uploaded_file = $upload_dir . $name . '.' . $this->imageFile->extension;
            if ($this->imageFile->saveAs($uploaded_file))
            {
                $this->uploadedFile['name'] = $name . '.' . $this->imageFile->extension;
                $this->uploadedFile['mime'] = $this->imageFile->extension;
                $this->uploadedFile['weight'] = filesize($uploaded_file);
                list($this->uploadedFile['width'], $this->uploadedFile['height']) = getimagesize($uploaded_file);

                return true;
            }
        }
        return false;
    }



    public function upload_______________________()
    {
        if ($this->validate())
        {
            $standard_names = []; //['1'=>'passport', '2'=>'education'];
            foreach (Files::TYPES as $key => $value) $standard_names[$value[0]] = $key;

            //$this->imageFile->baseName
            $uid = Yii::$app->user->id;
            $name = 'user' . $uid . '_' . $this->randomize();
            $upload_dir = Yii::$app->params['uploadDir'] . DIRECTORY_SEPARATOR;

            $uploaded_file = $upload_dir . $name . '.' . $this->imageFile->extension;
            if ($this->imageFile->saveAs($uploaded_file))
            {
                $this->uploadedFile['name'] = $name . '.' . $this->imageFile->extension;
                $this->uploadedFile['mime'] = $this->imageFile->extension;
                $this->uploadedFile['weight'] = filesize($uploaded_file);
                list($this->uploadedFile['width'], $this->uploadedFile['height']) = getimagesize($uploaded_file);
            }

            $existing_files = Files::find()->where(['uid' => $uid, 'mime' => 'jpg', 'doctype' => $this->doctype])->asArray()->all();

            $pages = [];
            foreach($existing_files as $file)
            {
                $pages[] = $upload_dir . $file['name'];
            }
            $pages[] = $upload_dir . $this->uploadedFile['name'];

            $pdf = new Imagick($pages);
            $pdf->setImageFormat('pdf');

            $pdf_name = 'user' . $uid . '_' . $standard_names[$this->doctype] . '.pdf';
            $pdf_path = $upload_dir . $pdf_name;

            if ($pdf->writeImages($pdf_path, true))
            {
                $this->convertedFile['name'] = $pdf_name;
                $this->convertedFile['mime'] = 'pdf';
                $this->convertedFile['weight'] = filesize($pdf_path);
            }
            else {
                die('Could not write!');
            }

//            print_r($existing_files);
//            exit();


//
//                //присоедить к существующему
//                $files_to_merge[] = Yii::$app->params['uploadDir'] . DIRECTORY_SEPARATOR . $existing_files['name'];
//                $files_to_merge[] = $pdf_name;//
//                $output_path = Yii::$app->params['uploadDir'] . DIRECTORY_SEPARATOR . 'merge.pdf';

//                MergePdf::merge($files_to_merge, MergePdf::DESTINATION__DISK, $output_path);
//

            return true;
        }
        else {
            return false;
        }
    }

    private function randomize()
    {
        return md5(microtime() . rand(0, 1000));
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