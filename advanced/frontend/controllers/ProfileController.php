<?php


namespace frontend\controllers;


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

            if ($model->upload())
            {
//                Yii::$app->session->setFlash('success', 'Изображение загружено');

//                return $this->render('fileForm', [
//                    'model' => $model
//                ]);

                return '<img src="/uploads/' . $model->imageFile->name . '" />';
            }
            else {
                return false;
            }
        }
        return false;
    }

    public function actionIndex()
    {
        $uid = Yii::$app->user->id;


        $model = User::findOne($uid);

//        print_r($model->getAvailablePrograms());

        $form = new ApplicationForm();

        $file_form = new FileForm();

        //обработка формы  $model->load(Yii::$app->request->post())
        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post()))
        {
            if ($form->createApplication())
            {
                Yii::$app->session->setFlash('success', 'Заявка успешно отправлена.');
            }
            else {
                Yii::$app->session->setFlash('error', 'Ошибка. Попробуйте еще раз.');
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