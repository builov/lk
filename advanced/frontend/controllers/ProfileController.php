<?php


namespace frontend\controllers;


use common\models\Files;
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
        $model = User::find()->all();

//        print_r($model);

        $users = [];
        foreach ($model as $user)
        {
            $key = 'user' . $user->id;

//            $users[$user->id]['id'] = $user->id;
            $users[$key]['lastname'] = $user->profile->lastname;
            $users[$key]['firstname'] = $user->profile->firstname;
            $users[$key]['patronim'] = $user->profile->patronim;
            $users[$key]['birthdate'] = $user->profile->birthdate;
            $users[$key]['snils'] = $user->profile->snils;
            $users[$key]['gender'] = $user->profile->gender;
            $users[$key]['education_level'] = $user->profile->education_level;
            $users[$key]['institution'] = $user->profile->institution;
            $users[$key]['graduate_year'] = $user->profile->graduate_year;
            $users[$key]['passport_series'] = $user->profile->passport_series;
            $users[$key]['passport_number'] = $user->profile->passport_number;
            $users[$key]['passport_issued'] = $user->profile->passport_issued;
            $users[$key]['passport_code'] = $user->profile->passport_code;
            $users[$key]['passport_date'] = $user->profile->passport_date;
            $users[$key]['region'] = $user->profile->region;
            $users[$key]['address_passport'] = $user->profile->address_passport;
            $users[$key]['address_current'] = $user->profile->address_current;
            $users[$key]['zip'] = $user->profile->zip;
            $users[$key]['phone'] = $user->profile->phone;
            $users[$key]['created'] = $user->profile->created;
        }

        return json_encode($users, JSON_UNESCAPED_UNICODE);
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
                $file = new Files();
                $file->uid = Yii::$app->user->id;
                $file->path = $model->webPath;
                $file->name = '';
                $file->sizex = '';
                $file->sizey = '';
                $file->mime = '';
                $file->weight = '';
                $file->created = time();
                $file->save();

                return '<div class="uploaded-image">
                            <div class="delete-image">Удалить</div>
                            <img src="/' . $model->webPath . '" />
                        </div>';
//                return '<img src="/uploads/' . $model->imageFile->name . '" />';
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