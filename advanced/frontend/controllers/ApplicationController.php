<?php

namespace frontend\controllers;

use common\models\Application;
use common\models\Comment;
use common\models\Message;
use common\models\Profile;
use common\models\Program;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Заявки на обучение
 */
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

    /**
     * просмотр заявки
     */
    public function actionIndex($id)
    {
        $model = Application::findOne($id);

        if ($model->uid != \Yii::$app->user->id) {
            throw new ForbiddenHttpException('Access denied');
        }

        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * форма для тестирования POST-запросов
     */
    public function actionTestForm()
    {
//        return 'ok';
        return $this->render('test-form');
    }

    /**
     * интерфейс обмена данными с 1С
     * ответ Приемной комиссии на заявку
     * принимает строку формата "статус (принято/отклонено)|id заявки|комментарий (код сообщения)"
     * возвращает http status code 201 в случае успешного выполнения
     */
    public function actionFeedback()
    {
        $request = Yii::$app->request;
        $data = $request->post('data');

//        $file = Yii::$app->params['uploadDir'] . DIRECTORY_SEPARATOR . 'log.txt';
//        file_put_contents($file, $data);

        $data_all_arr = explode(PHP_EOL, $data);

//        print_r($data);

        foreach ($data_all_arr as $data_str)
        {
            $data_arr = explode('|', $data_str);

            if (count($data_arr) < 3) continue;

            $status = $data_arr[0]; //статус заявки
            $application_id = (int) $data_arr[1];
            $message_code = $data_arr[2];

            if (in_array($status, ['3','4','5']) && $application_id) //см. Application::STATUSES
            {
                if ($application = Application::findOne($application_id))
                {
                    $application->status = $status;
                    $application->updated = time();
                    $application->show_message = 1;
                    if ($application->save())
                    {
                        if ($status=='4') //для статуса "заявка отклонена": Комментарий
                        {
                            //todo может оно и вообще не нужно, достаточно Сообщений
                            $comment = new Comment();
                            $comment->appl_id = $application_id;
                            $comment->body = $message_code;
                            $comment->created = time();
                            $comment->save();
                        }

                        //создание и сохранение сообшения в БД
                        $message = new Message();
                        $message->uid = $application->uid;
                        $message->created = time();
                        $message->updated = time();
                        $message->status = 1;
                        $message->appl_id = $application->id;
                        $message->code = $message_code;

                        if ($message->save())
                        {
//                            print_r($application->program->name);

                            //отправка письма с сообщением
                            $user = User::find()->where(['id' => $message->uid])->one();
                            $subj = 'Сообщение от Приемной комиссии';
                            $data = [];
                            $data['course'] = $application->program->name;

                            if ($user->sendEmail($message, $subj, $data)) Yii::$app->response->statusCode = 201;
                        }
//                        Yii::$app->response->statusCode = 201;
                    }

                }
            }
        }
    }

    /**
     * интерфейс обмена данными с 1С
     * принимает id заявки на обучение
     * присваивает заявке status=2 (на рассмотрении)
     * возвращает http status code 201 в случае успешного выполнения
     */
    public function actionSaved($id)
    {
        //todo проверять ip-адрес
        $file = Yii::$app->params['uploadDir'] . DIRECTORY_SEPARATOR . 'log.txt';
        $ip = Yii::$app->getRequest()->getUserIP();
        file_put_contents($file, $ip);





//        $model = Application::findOne($id);
//        if ($model['status']==1) $model['status'] = 2;
//        $model['updated'] = time();
//        if ($model->save())
//        {
//            //создание и сохранение сообшения в БД
//            $message = new Message();
//            $message->uid = $model->uid;
////            $message->type;
//            $message->created = time();
//            $message->updated = time();
//            $message->status = 1;
//            $message->appl_id = $model->id;
////            $message->date;
//            $message->code = '1040';
//
//            if ($message->save())
//            {
//                //отправка письма с сообщением
//                $user = User::find()->where(['id' => $message->uid])->one();
//                $subj = 'Сообщение от Приемной комиссии';
//                $data['course'] = $model->program->name;
//
//                if ($user->sendEmail($message, $subj, $data)) Yii::$app->response->statusCode = 201;
//            }
//        }
    }

    /**
     * интерфейс обмена данными с 1С
     * возвращает json массив новых заявок на обучение (status=1)
     */
    public function actionExport()
    {
        $model = Application::find()->where(['status'=>1])->all();

        $apps = [];
        foreach ($model as $application)
        {
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
                'https://lks.medcollege7.ru/uploads/user'. $application->user->id . '_education.pdf',
                'https://lks.medcollege7.ru/uploads/user'. $application->user->id . '_achievements.pdf'
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

        return json_encode($res, JSON_UNESCAPED_UNICODE);
    }
}