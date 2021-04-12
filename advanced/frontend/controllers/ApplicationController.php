<?php


namespace frontend\controllers;


use common\models\Application;
use common\models\Comment;
use common\models\Profile;
use common\models\Program;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class ApplicationController extends Controller
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

    public function beforeAction($action)
    {
        if (in_array($action->id, ['feedback'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionTestForm()
    {
//        return 'ok';
        return $this->render('test-form');
    }

    public function actionFeedback()
    {
        $request = Yii::$app->request;
        $data = $request->post('data');

//        $data = "4|21|Заявление принято
//4|22|Заявление принято";

//        $file = Yii::$app->params['uploadDir'] . DIRECTORY_SEPARATOR . 'log.txt';
//        file_put_contents($file, $data);

        $data_all_arr = explode(PHP_EOL, $data);

        foreach ($data_all_arr as $data_str)
        {
//            echo $data_str . "\n";

            $data_arr = explode('|', $data_str);

            if (count($data_arr) < 3) continue;

            $status = $data_arr[0];
            $application_id = (int) $data_arr[1];
            $comment_text = $data_arr[2];

//        $data = serialize($_POST);
//        $data = 'Статус: ' . $status . '; ID: ' . $application_id . '; Комментарий: ' . $comment_text . ".\n\n";

//        $status = $request->post('status', 0);
//        $application_id = (int) $request->post('id', 0);
//        $comment_text = $request->post('comment', 0);

//        $_1C_statuses = ['3'=>'Принято', '4'=>'Отказано']; //совместимость с Application::STATUSES

            if (in_array($status, ['3','4', '5']) && $application_id)
            {
                if ($application = Application::findOne($application_id))
                {
//                foreach ($_1C_statuses as $key => $value) if ($status == $value)
//                    $application->status = $key;
                    $application->status = $status;
                    $application->updated = time();
                    $application->show_message = 1;
                    $application->save();

                    if ($status=='3') //для статуса "заявка отклонена"
                    {
                        $comment = new Comment();
                        $comment->appl_id = $application_id;
                        $comment->body = $comment_text;
                        $comment->created = time();
                        $comment->save();
                    }

                }
            }
        }
    }

    public function actionSaved($id)
    {
        //todo проверять ip-адрес
        $model = Application::findOne($id);
        if ($model['status']==1) $model['status'] = 2;
        $model['updated'] = time();
        $model->save();
    }


    public function actionExport()
    {
        $model = Application::find()->where(['status'=>1])->all();

//        print_r($model);

        $apps = [];
        foreach ($model as $application)
        {
            $key = 'appl' . $application->id;

            $key = $application->id;

//            print_r($application->user->files);
//            exit();

            $apps[$key]['programs'] = [$application->program->id => $application->program->name];
            $apps[$key]['program_base'] = $application->program->base; //Profile::_EDUCATION[$application->program->base];
            $apps[$key]['program_type'] = Program::_TYPES[$application->program->type];
            $apps[$key]['program_financing'] = Program::_FINANCING[$application->program->financing];
            $apps[$key]['user_id'] = $application->user->id;
            $apps[$key]['user_email'] = $application->user->email;
            $apps[$key]['user_lastname'] = $application->user->profile->lastname;
            $apps[$key]['user_firstname'] = $application->user->profile->firstname;
            $apps[$key]['user_patronim'] = $application->user->profile->patronim;
            $apps[$key]['user_birthdate'] = $application->user->profile->birthdate;
            $apps[$key]['user_region'] = $application->user->profile->region; //Profile::_REGION[$application->user->profile->region];
            $apps[$key]['user_snils'] = $application->user->profile->snils;
            $apps[$key]['user_gender'] = Profile::_GENDER[$application->user->profile->gender];
            $apps[$key]['user_education_level'] = $application->user->profile->education_level; //Profile::_EDUCATION[$application->user->profile->education_level];
            $apps[$key]['user_institution'] = $application->user->profile->institution;
            $apps[$key]['user_graduate_year'] = $application->user->profile->graduate_year;
            $apps[$key]['user_certificate_series'] = $application->user->profile->certificate_series;
            $apps[$key]['user_certificate_number'] = $application->user->profile->certificate_number;
            $apps[$key]['user_passport_series'] = $application->user->profile->passport_series;
            $apps[$key]['user_passport_number'] = $application->user->profile->passport_number;
            $apps[$key]['user_passport_issued'] = $application->user->profile->passport_issued;
            $apps[$key]['user_passport_code'] = $application->user->profile->passport_code;
            $apps[$key]['user_passport_date'] = $application->user->profile->passport_date;
//            $apps[$key]['user_region'] = Profile::_REGION[$application->user->profile->region];
            $apps[$key]['user_address_passport'] = $application->user->profile->address_passport;
            $apps[$key]['user_address_current'] = $application->user->profile->address_current;
//            $apps[$key]['user_zip'] = $application->user->profile->zip;
            $apps[$key]['user_phone'] = $application->user->profile->phone;
//            $apps[$key]['appl_created'] = date("Y-m-d", $application->created);
//            foreach ($application->user->files as $file) if ($file->mime == 'pdf') $files[] = 'https://lks.medcollege7.ru/uploads/' . $file->name;
            $apps[$key]['user_files'] = [
                'https://lks.medcollege7.ru/uploads/user'. $application->user->id . '_passport.pdf',
                'https://lks.medcollege7.ru/uploads/user'. $application->user->id . '_education.pdf'
            ];
        }

//        print_r($apps);

        $data = [];
        foreach ($apps as $appl_id => $app)
        {
            if (!array_key_exists($app['user_id'], $data))
            {
                $data[$app['user_id']] = $app;
                $data[$app['user_id']]['programs'] = [];
//                $data[$app['user_id']]['programs'][] = $app['programs'];
                foreach ($app['programs'] as $id => $name)
                {
                    $id = 'program' . $id;
                    $appl = 'appl' . $appl_id;
                    $data[$app['user_id']]['programs'][$appl] = [$id => $name];
                }
            }
            else {
                foreach ($app['programs'] as $id => $name)
                {
                    $id = 'program' . $id;
                    $appl = 'appl' . $appl_id;
                    $data[$app['user_id']]['programs'][$appl] = [$id => $name];
                }

            }
        }

        $res = array_values($data);

//        print_r($res);


        return json_encode($res, JSON_UNESCAPED_UNICODE);
    }
}