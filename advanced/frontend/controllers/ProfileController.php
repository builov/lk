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

    public function actionExport()
    {
        $model = Application::find()->all();

//        print_r($model);

        $apps = [];
        foreach ($model as $application)
        {
            $key = 'appl' . $application->id;

//            print_r($application->user->files);
//            exit();

            $apps[$key]['program_name'] = $application->program->name;
            $apps[$key]['program_base'] = Profile::_EDUCATION[$application->program->base];
            $apps[$key]['program_type'] = Program::_TYPES[$application->program->type];
            $apps[$key]['program_financing'] = Program::_FINANCING[$application->program->financing];
            $apps[$key]['user_lastname'] = $application->user->profile->lastname;
            $apps[$key]['user_firstname'] = $application->user->profile->firstname;
            $apps[$key]['user_patronim'] = $application->user->profile->patronim;
            $apps[$key]['user_birthdate'] = $application->user->profile->birthdate;
            $apps[$key]['user_snils'] = $application->user->profile->snils;
            $apps[$key]['user_gender'] = Profile::_GENDER[$application->user->profile->gender];
            $apps[$key]['user_education_level'] = Profile::_EDUCATION[$application->user->profile->education_level];
            $apps[$key]['user_institution'] = $application->user->profile->institution;
            $apps[$key]['user_graduate_year'] = $application->user->profile->graduate_year;
            $apps[$key]['user_passport_series'] = $application->user->profile->passport_series;
            $apps[$key]['user_passport_number'] = $application->user->profile->passport_number;
            $apps[$key]['user_passport_issued'] = $application->user->profile->passport_issued;
            $apps[$key]['user_passport_code'] = $application->user->profile->passport_code;
            $apps[$key]['user_passport_date'] = $application->user->profile->passport_date;
            $apps[$key]['user_region'] = Profile::_REGION[$application->user->profile->region];
            $apps[$key]['user_address_passport'] = $application->user->profile->address_passport;
            $apps[$key]['user_address_current'] = $application->user->profile->address_current;
            $apps[$key]['user_zip'] = $application->user->profile->zip;
            $apps[$key]['user_phone'] = $application->user->profile->phone;
            $apps[$key]['appl_created'] = date("Y-m-d", $application->created);
//            foreach ($application->user->files as $file) if ($file->mime == 'pdf') $files[] = 'https://lks.medcollege7.ru/uploads/' . $file->name;
            $apps[$key]['user_files'] = [
                'https://lks.medcollege7.ru/uploads/user'. $application->user->id . '_passport.pdf',
                'https://lks.medcollege7.ru/uploads/user'. $application->user->id . '_education.pdf'
            ];
        }

        return json_encode($apps, JSON_UNESCAPED_UNICODE);
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
                $file->doctype = $model->doctype;
                $file->save();

                return '<div class="uploaded-image">                            
                            <img src="/uploads/' . $model->uploadedFile['name'] . '" />
                        </div>';
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