<?php


namespace frontend\controllers;


use common\models\Application;
use common\models\Files;
use common\models\Message;
use common\models\Program;
use common\models\User;
use common\models\Profile;
use frontend\models\ApplicationForm;
use frontend\models\EditProfileForm;
use frontend\models\FileForm;
use frontend\models\RegisterForm;
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


    public function actionEdit()
    {
        $uid = Yii::$app->user->id;
        $user = User::find($uid)->one();

        $profile = $user->profile;

        $model = new EditProfileForm(); //todo не подойдет, лучше сделать отдельную форму

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()))
        {
            echo 'sdfsdf';

//            if (!$model->check())
//            {
//                Yii::$app->session->setFlash('error', 'Ошибка...');
//                return;
//            }
        }

//        print_r($profile);

//        $model->lastname = $profile->lastname;
//        $model->firstname = $profile->firstname;
//        $model->patronim = $profile->patronim;
//        $model->birthdate = $profile->birthdate;
//        $model->snils = $profile->snils;
//        $model->gender = $profile->gender;
//        $model->education_level = $profile->education_level;
//        $model->institution = $profile->institution;
//        $model->graduate_year = $profile->graduate_year;
//        $model->certificate_series = $profile->certificate_series;
//        $model->certificate_number = $profile->certificate_number;
//        $model->passport_series = $profile->;
//        $model->passport_number = $profile->;
//        $model->passport_issued = $profile->;
//        $model->passport_code = $profile->;
//        $model->passport_date = $profile->;
//        $model->citizenship = $profile->;
//        $model->region = $profile->;
//        $model->address_passport_street = $profile->;
//        $model->address_passport_building = $profile->;
//        $model->address_passport_apartment = $profile->;
//        $model->address_current_street = $profile->;
//        $model->address_current_building = $profile->;
//        $model->address_current_apartment = $profile->;
//        $model->phone = $profile->;
//        $model->email = $profile->;
//        $model->agree = $profile->;
//        $model->addresses_coincide = $profile->;

//        $model->load($user->profile); //чето не работает :(

        return $this->render('editForm', [
            'model' => $model,
        ]);

    }


    public function actionDontShowMessage($id)
    {
        $uid = Yii::$app->user->id;
        $message = Message::find()->where(['uid' => $uid, 'id' => $id])->one();
        $message->status = 0;
        if (!$message->save()) Yii::$app->session->setFlash('error', 'Ошибка обработки запроса.');

        return $this->redirect(['/profile']);
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
        $uid = Yii::$app->user->id;
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

        $messages = Message::find()->where(['uid' => $uid, 'status' => 1])->all();

//        print_r($messages);

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

        if ($mode=='form' && 1) //todo добавить условие, что есть программы, на которые еще можно отправить заявку (неотправленные + отклоненные)
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
            'messages' => $messages,
        ]);
    }
}