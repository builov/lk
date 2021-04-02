<?php


namespace frontend\controllers;


use common\models\Application;
use common\models\Files;
use common\models\Program;
use common\models\User;
use common\models\Profile;
use frontend\models\ApplicationForm;
use frontend\models\FileForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\UploadedFile;

class ProfileController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }



    public function actionUploadFile()
    {
//        $this->layout = false;

        $model = new FileForm();

        if (Yii::$app->request->isPost)
        {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->doctype = Yii::$app->request->post()['FileForm']['doctype'];

            if ($model->upload())
            {
                $f = $model->uploadedFile;
                $file = new Files();
                $file->uid = Yii::$app->user->id;
                $file->path = $f['name'];
                $file->name = $f['name'];
                $file->sizex = key_exists('width', $f) ? $f['width'] : '';
                $file->sizey = key_exists('height', $f) ? $f['height'] : '';
                $file->mime = $f['mime'];
                $file->weight = $f['weight'];
                $file->created = time();
                $file->doctype = $model->doctype;
                $file->save();

                $f = $model->convertedFile;
                if (!$file = Files::find()->where(['name' => $f['name']])->one())
                {
                    $file = new Files();
                }
                $file->uid = Yii::$app->user->id;
                $file->path = $f['name'];
                $file->name = $f['name'];
                $file->sizex = key_exists('width', $f) ? $f['width'] : '';
                $file->sizey = key_exists('height', $f) ? $f['height'] : '';
                $file->mime = $f['mime'];
                $file->weight = $f['weight'];
                $file->created = time();
                $file->doctype = $model->doctype . $model->doctype;
                $file->save();

//                return '<div class="uploaded-image">
//                            <img src="/uploads/' . $model->uploadedFile['name'] . '" />
//                        </div>';

                return "<div class=\"img-uploaded\" style=\"background-image: url('/uploads/" . $model->uploadedFile['name'] . "')\" >&nbsp;</div>";            }
            else {
                return false;
            }
        }
        return false;
    }

    public function actionIndex()
    {
        $uid = Yii::$app->user->id;

//        echo Yii::$app->params['uploadDir'];

        $model = User::findOne($uid);

        foreach($model->files as $file)
        {
            if ($file->mime=='jpg')
            {
                if ($file->doctype==1) $model->passport_files[] = $file;
                else if ($file->doctype==2) $model->education_files[] = $file;
            }
        }

        $form = new ApplicationForm();

        $file_form = new FileForm();

        //обработка формы  $model->load(Yii::$app->request->post())
        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post()))
        {
            if ($form->duplicationCheck() && $form->docsCheck())
            {
                if ($form->createApplication())
                {
                    Yii::$app->session->setFlash('success', 'Заявка успешно отправлена.');
                }
                else {
                    Yii::$app->session->setFlash('error', 'Ошибка. Попробуйте еще раз.');
                }
            }

//            print_r($form);

//            //загрузка файлов
//            $form->imageFiles = UploadedFile::getInstances($form, 'imageFiles');
//            if ($form->upload())
//            {
//                Yii::$app->session->setFlash('success', 'Документы успешно загружены.');
//            }
//            else {
//                Yii::$app->session->setFlash('error', 'Ошибка загрузки документов.');
//            }
        }

//        print_r($model->profile);



        // предъявление формы
        return $this->render('view', [
            'model' => $model,
            'appform' => $form,
            'file_form' => $file_form,
        ]);
    }
}