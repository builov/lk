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
                Yii::$app->response->setStatusCode(415);
                return false;
            }
        }
        return false;
    }

//    public function actionApplicationForm()
//    {
//        $uid = Yii::$app->user->id;
//        $model = User::findOne($uid);
//        foreach($model->files as $file)
//        {
//            if ($file->mime=='jpg')
//            {
//                if ($file->doctype==1) $model->passport_files[] = $file;
//                else if ($file->doctype==2) $model->education_files[] = $file;
//            }
//        }
//        $form = new ApplicationForm();
//        $file_form = new FileForm();
//        $sent_applications = $model->getSentApplications();
//        return $this->render('applicationFormPage', [
//            'model' => $model,
//            'appform' => $form,
//            'file_form' => $file_form,
//            'sent_applications' => $sent_applications,
//        ]);
//    }

    public function actionIndex($mode='default')
    {
        $model = User::findOne(Yii::$app->user->id);

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
//            else return $this->redirect(Yii::$app->request->referrer);

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

        //отправленные заявки ($applied_programs)
        //опции для селекта: доступные программы ($available_programs) - одобренные заявки ($accepted_programs)
        //условие показа кнопки: доступные программы ($available_programs) - отправленные заявки ($applied_programs)

        $sent_applications = $model->getSentApplications(); //для вывода отправленных заявок со статусами и комментариями
        $available_programs = $model->getAvailablePrograms(); //доступные для абитуриента программы
//        $applied_programs = []; //отправленные заявки (program->id => program->name)
//        $accepted_programs = []; //одобренные заявки (program->id => program->name)
//        foreach ($model->applications as $application)
//        {
//            $applied_programs[] = $application->program->name;
//            if ($application->status < Application::STATUS_DECLINED)
//            {
//                $accepted_programs[] = $application->program->name; //если статус 1,2,3
//            }
//        }

//        print_r($sent_applications);

        if ($mode=='form' && 1)
        {
            return $this->render('applicationFormPage', [
                'model' => $model,
                'appform' => $form,
                'file_form' => $file_form,
                'sent_applications' => $sent_applications,
                'available_programs' => $available_programs,
            ]);
        }
        return $this->render('view', [
            'model' => $model,
            'appform' => $form,
            'file_form' => $file_form,
            'sent_applications' => $sent_applications,
            'available_programs' => $available_programs,
        ]);
    }
}