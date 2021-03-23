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
//            $users[$user->id]['id'] = $user->id;
            $users[$user->id]['lastname'] = $user->profile->lastname;
            $users[$user->id]['firstname'] = $user->profile->firstname;
            $users[$user->id]['patronim'] = $user->profile->patronim;
//            $users[$user->id]['birthdate'] = $user->profile->birthdate;
//            $users[$user->id]['snils'] = $user->profile->snils;
//            $users[$user->id]['gender'] = $user->profile->gender;
//            $users[$user->id]['education_level'] = $user->profile->education_level;
//            $users[$user->id]['institution'] = $user->profile->institution;
//            $users[$user->id]['graduate_year'] = $user->profile->graduate_year;
//            $users[$user->id]['passport_series'] = $user->profile->passport_series;
//            $users[$user->id]['passport_number'] = $user->profile->passport_number;
//            $users[$user->id]['passport_issued'] = $user->profile->passport_issued;
//            $users[$user->id]['passport_code'] = $user->profile->passport_code;
//            $users[$user->id]['passport_date'] = $user->profile->passport_date;
//            $users[$user->id]['region'] = $user->profile->region;
//            $users[$user->id]['address_passport'] = $user->profile->address_passport;
//            $users[$user->id]['address_current'] = $user->profile->address_current;
//            $users[$user->id]['zip'] = $user->profile->zip;
//            $users[$user->id]['phone'] = $user->profile->phone;
//            $users[$user->id]['created'] = $user->profile->created;
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