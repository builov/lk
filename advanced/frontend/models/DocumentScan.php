<?php


namespace frontend\models;


use common\models\Files;
use common\models\User;
use Yii;
use yii\base\Model;

class DocumentScan extends Model
{
//    const TYPES = ['passport' => [1,11], 'education' => [2,22], 'achievements' => [3,33]];

    public $doctype;
    public $files;
    public $user;
    public $uid;

    public function init()
    {
        parent::init();
        if (!isset($this->uid)) $this->uid = Yii::$app->user->id;
    }

    public function delete()
    {
        $types = implode(",", Files::TYPES[$this->doctype]);
        $upload_dir = Yii::$app->params['uploadDir'] . DIRECTORY_SEPARATOR;
        $deleted_dir = $upload_dir . 'deleted' . DIRECTORY_SEPARATOR;

//        $files = Files::find()->where(['uid' => $this->uid])->andWhere(['in','doctype', $types])->all();

        $connection = Yii::$app->db;
        $files = $connection->createCommand("SELECT id, name FROM files WHERE uid=:uid AND doctype IN($types)")
            ->bindValue(':uid', $this->uid)
            ->queryAll();

        foreach ($files as $file)
        {
            try {
                rename($upload_dir . $file['name'], $deleted_dir . $file['name']);
            }
            catch (\ErrorException $e) {
                Yii::$app->session->setFlash('error', 'Ошибка выполнения rename()');
                return;
            }
            $connection->createCommand('DELETE FROM files WHERE id=:id')
                ->bindValue(':id', $file['id'])
                ->execute();
        }

//        print_r($files);
    }
}