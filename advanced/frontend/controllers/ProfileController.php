<?php


namespace frontend\controllers;


use common\models\Application;
use common\models\Files;
use common\models\Message;
use common\models\Program;
use common\models\User;
use common\models\Profile;
use frontend\models\ApplicationForm;
use frontend\models\DocumentScan;
use frontend\models\EditProfileForm;
use frontend\models\FileForm;
use frontend\models\RegisterForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;

class ProfileController extends Controller
{
//    actions:
//    actionDeleteScan($type)
//    actionEdit()
//    actionDontShowMessage($id)
//    actionUploadFile()
//    actionTest()
//    actionIndex($mode='default')


    public function behaviors()
    {
//        $profile = Profile::find()->where(['uid' => Yii::$app->user->id])->one();
        return [
            'access' => [
                'class' => AccessControl::className(),
//                'only' => ['index'],
                'rules' => [
                    [
//                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Удаление сканов документов текущего пользователя (.pdf)
     * @param $type: 'passport', 'education', 'achievements'
     * @return \yii\web\Response
     */
    public function actionDeleteScan($type)
    {
        $scan = new DocumentScan(['doctype' => $type, 'uid' => Yii::$app->user->id]);
//        print_r($scan->doctype);
        $scan->delete();
        return $this->redirect(Yii::$app->request->referrer);
    }


    /**
     * Удаление файлов текущего пользователя (img)
     * @return \yii\web\Response
     */
    public function actionDeleteFile($id)
    {
        //todo проверка разрешения на редактирование профиля

        $user = User::find()->where(['id' => Yii::$app->user->id])->one();
        $user->deleteFile((int) $id);
        return $this->redirect(Yii::$app->request->referrer);
    }


    public function actionEdit()
    {
//        $this->layout = 'new2';

//        $uid = Yii::$app->user->id;
//        $user = User::find($uid)->one();
//        $profile = Profile::find()->where(['uid' => Yii::$app->user->id])->one();

        $condition = [2,3]; //заявка в статусе "на рассмотрении" или "одобрена"
        if (Application::find()->where(['uid' => Yii::$app->user->id])->andWhere(['in','status',$condition])->count())
        {
            Yii::$app->session->setFlash('error', 'Не допускается редактирование профиля при наличии заявки, находящейся на рассмотрении или одобренной.');
            return $this->redirect(['/profile']); //редактирование постфактум запрещено
        }


        $model = new EditProfileForm(); //заполняется данными текущего пользователя в init()

//        print_r($model);

        if (Yii::$app->request->isPost)
        {
            if ($model->load(Yii::$app->request->post()))
            {
                if (!$model->check()) //todo сейчас ничего не проверяется
                {
                    Yii::$app->session->setFlash('error', 'Ошибка...');
                }
                else {

//                    print_r($model);

                    //сохранение профиля
                    if ($model->updateProfile()) Yii::$app->session->setFlash('success', 'Изменения успешно сохранены.');
                    return $this->redirect(['/profile']);
                }
            }
            else {
                Yii::$app->session->setFlash('error', 'Что-то пошло не так...');
            }
        }

        return $this->redirect(['/profile']);

//        return $this->render('editForm', [
//            'model' => $model,
//        ]);

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
        $this->layout = false;

        $model = new FileForm();

        if (Yii::$app->request->isPost)
        {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->doctype = Yii::$app->request->post()['FileForm']['doctype']; //doctype был нужен, были отдельно сканы паспорта, док. об образовании и т.д., сейчас не используется

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

//                return "<div class=\"img-uploaded\" style=\"background-image: url('/uploads/" . $model->uploadedFile['name'] . "')\" >&nbsp;</div>";

                return "<div class=\"img-uploaded\" style=\"background-image: url('/uploads/" . $file->name . "')\" >&nbsp;
                            <a class=\"delete-file\" href=\"/delete-file/" . $file->id . "\">удалить</a>
                        </div>";
            }
            else {
                Yii::$app->response->setStatusCode(415);
                return false;
            }
        }
        return false;
    }


    public function actionUploadFile__________________________()
    {
        $this->layout = false;

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

    public function actionTest()
    {


        $arr = [];
        foreach (Files::TYPES as $key => $value)
        {
            $arr[$value[0]] = $key;
        }

        print_r($arr);
    }




    public function actionIndex($mode='default')
    {
//        //пример применения RBAC Rules. Проверено, вроде работает.
//        $profile = Profile::find()->where(['uid' => Yii::$app->user->id])->one();
//        if (\Yii::$app->user->can('viewOwnProfile', ['profile' => $profile])) {
//            throw new ForbiddenHttpException('Access denied');
//        }

        $this->layout = 'new2';


        $uid = Yii::$app->user->id;
        $model = User::findOne($uid);

//        print_r(Files::TYPES);

        foreach($model->files as $file)
        {
            if ($file->mime=='jpg')
            {
                if ($file->doctype==Files::TYPES['passport'][0]) $model->passport_files[] = $file;
                else if ($file->doctype==Files::TYPES['education'][0]) $model->education_files[] = $file;
                else if ($file->doctype==Files::TYPES['achievements'][0]) $model->achievements_files[] = $file;
            }
        }

        $form = new ApplicationForm();

        $file_form = new FileForm();

        $edit_profile_form = new EditProfileForm(); //заполняется данными текущего пользователя в init()

        //обработка формы  $model->load(Yii::$app->request->post())
        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post()))
        {
            if ($form->duplicationCheck() && $form->docsCheck())
            {
                if ($form->createApplication())
                {
                    Yii::$app->session->setFlash('success', 'Заявка успешно отправлена.');
                    return $this->redirect(['/profile']);
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

//        echo count($sent_applications[1]);


        $editable = false;
        if (!count($sent_applications[1])) $editable = true;
        else {
            $applications_statuses = [];
            foreach ($sent_applications[0] as $application)
            {
                $applications_statuses[] = $application[1];
            }
            if (count($applications_statuses)
                && !in_array(Application::STATUS_IN_PROCESS, $applications_statuses)
                && !in_array(Application::STATUS_ACCEPTED, $applications_statuses))
            {
                $editable = true;
            }
        }

//        echo var_dump($editable);

        if ($mode=='form' && 1) //todo добавить условие, что есть программы, на которые еще можно отправить заявку (неотправленные + отклоненные)
        {
            return $this->render('applicationFormPage', [
                'model' => $model,
                'appform' => $form,
                'file_form' => $file_form,
                'sent_applications' => $sent_applications,
                'available_programs' => $available_programs,
                'editable' => $editable,
            ]);
        }

        $messages = Message::find()->where(['uid' => $uid, 'status' => 1])->all();

        return $this->render('view', [
            'model' => $model,
            'appform' => $form,
            'file_form' => $file_form,
            'sent_applications' => $sent_applications,
            'available_programs' => $available_programs,
            'messages' => $messages,
            'editable' => $editable,
            'edit_profile_form' => $edit_profile_form,
        ]);
    }
}