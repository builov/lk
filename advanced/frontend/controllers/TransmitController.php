<?php

namespace frontend\controllers;

use common\models\Application;
use common\models\Comment;
use common\models\Message;
use common\models\MessageTemplate;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * интерфейс обмена данными с 1С
 */
class TransmitController extends Controller
{
    public function beforeAction($action)
    {
        if (in_array($action->id, ['message'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    /**
     * интерфейс обмена данными с 1С
     * принимает id пользователя
     * возвращает массив сообщений пользователя (последнее сообщение каждого типа (type))
     */
    public function actionUserMessages($id)
    {
//        $user = User::findOne($id);
        $messages = Message::find()->select('id,type')->where(['uid' => $id])->asArray()->all();

        $data['user'] = $id;
        $data['messages'] = [];
        foreach ($messages as $message)
        {
            $data['messages']['type' . $message['type']] = $message['id'];
        }
        return json_encode($data);
    }

    /**
     * интерфейс обмена данными с 1С
     *
     * запросы отправляются автоматически раз в 2 часа
     * тип 2  - может быть много. Уточнить у ПК
     *
     * создает сообщение для пользователя в ЛК
     * принимает строку формата "тип сообщения|uid|дата|код сообщения по АИС" или "тип сообщения|uid|дата|код сообщения по АИС|id заявки"
     * тип сообщения:
     * 1 - дата собеседования (псих. тестирования),
     * 2 - результат собеседовани/тестирования,
     * 3 - рекомендация к зачислению или отказ в зачислении
     * формат сегмента "дата": 08.06.2021 15:26:12
     * возвращает http status code 201 в случае успешного выполнения
     */
    public function actionMessage()
    {
//        $file = Yii::$app->params['uploadDir'] . DIRECTORY_SEPARATOR . 'log.txt';

        $request = Yii::$app->request;
        $data = $request->post('data');

        $data_all_arr = explode(PHP_EOL, $data);

        foreach ($data_all_arr as $data_str)  //todo посмотреть как будет работать для больших объемов данных (например, рассылка уведомлений о приеме 1046.2
        {
            $data_arr = explode('|', $data_str);

            //print_r($data_arr);

            if (count($data_arr) < 3) continue;

            $message_type = (int) $data_arr[0];
            $user_id = (int) $data_arr[1];
            $event_date = $data_arr[2];
            $message_code = $data_arr[3];
            $appl_id = (array_key_exists(4, $data_arr)) ? $data_arr[4] : 0; //todo передается не название курса, а id заявки

            //сохранение сообшения в БД
            $message = new Message();
            $message->uid = $user_id;
            $message->type = $message_type;
//            if ($message_type==1) $message->body = 'Дата тестирования: ' . date('d-m-Y H:i', strtotime($event_date));
            $message->created = time();
            $message->updated = time();
            $message->status = 1;
            $message->appl_id = $appl_id;
            $message->date = strtotime($event_date);  //todo работающий на данный момент вариант.
            $message->code = $message_code;

            $message->save();

//            if ($message->save()) Yii::$app->response->statusCode = 201;
//            {
//                $course_name = ($appl_id > 0) ? $message->application->program->name : '';
//
//                //отправка письма с сообщением
//                $user = User::find()->where(['id' => $user_id])->one();
//                $subj = 'Сообщение от Приемной комиссии';
//                $data = [];
//                $data['course'] = $course_name;
//                $data['datetime'] = date('d-m-Y H:i', strtotime($event_date));
//
//                if ($user->sendEmail($message, $subj, $data))
//                    Yii::$app->response->statusCode = 201;
//            }
        }

        Yii::$app->response->statusCode = 201;
    }
}