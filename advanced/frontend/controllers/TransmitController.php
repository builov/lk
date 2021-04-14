<?php


namespace frontend\controllers;


use common\models\Application;
use common\models\Comment;
use common\models\Message;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class TransmitController extends Controller
{
    public function beforeAction($action)
    {
        if (in_array($action->id, ['message'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }



    public function actionMessage()
    {
        $request = Yii::$app->request;
        $data = $request->post('data');

        $file = Yii::$app->params['uploadDir'] . DIRECTORY_SEPARATOR . 'log.txt';
        file_put_contents($file, $data);

        $data_all_arr = explode(PHP_EOL, $data);

        $response_body = [];

        foreach ($data_all_arr as $data_str)
        {
            $data_arr = explode('|', $data_str);

            if (count($data_arr) < 3) continue;

            $message_type = (int) $data_arr[0];
            $user_id = (int) $data_arr[1];
            $event_date = $data_arr[2];
            $message_body = $data_arr[3];

            $model = new Message();
            $model->uid = $user_id;
            $model->type = $message_type;
            if ($message_type==1)
            {
                $model->body = 'Дата тестирования: ' . $event_date . '. ' . $message_body;
            }
            $model->created = time();
            $model->updated = time();
            $model->status = 1;
            $model->save();
            $response_body[] = ['uid' => $model->uid];
        }
//        return implode("|", $response_body);
//        return json_encode($response_body, JSON_UNESCAPED_UNICODE);
        return '[
                    {
                        "programs":{"appl18":{"program3":"Сестринское дело очно-заочная, после 11 кл., договор"}},		
                        "program_base":"2",		program_type":"очно-заочно",
                        "program_financing":"договор",
                        "user_id":69,
                        "user_email":"builov@inbox.ru",
                        "user_lastname":"Буйлов",
                        "user_firstname":"Дмитрий",
                        "user_patronim":"",
                        "user_birthdate":"1970-09-24",
                        "user_region":4,"user_snils":"",
                        "user_gender":"Мужской",
                        "user_education_level":5,
                        "user_institution":"ПТУ №1",
                        "user_graduate_year":2020,
                        "user_certificate_series":"",
                        "user_certificate_number":"1234567",
                        "user_passport_series":"",
                        "user_passport_number":"234234",
                        "user_passport_issued":"УВД",
                        "user_passport_code":"",
                        "user_passport_date":"2020-11-11",
                        "user_address_passport":"121108, г. Москва, ул. Пивченкова, дом 12, квартира 31",
                        "user_address_current":"121108, г. Москва, ул. Пивченкова, дом 12, квартира 31",
                        "user_phone":"+7 (123) 123-12-31",
                        "user_files":["https:\/\/lks.medcollege7.ru\/uploads\/user69_passport.pdf","https:\/\/lks.medcollege7.ru\/uploads\/user69_education.pdf"]
                    }
                ]';
    }
}