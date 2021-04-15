<?php

namespace frontend\controllers;

use common\models\Application;
use common\models\Comment;
use common\models\Message;
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
     * создает сообщение для пользователя в ЛК
     * принимает строку формата "тип сообщения|uid|дата|код сообщения по АИС"
     * возвращает http status code 201 в случае успешного выполнения
     */
    public function actionMessage()
    {
//        $file = Yii::$app->params['uploadDir'] . DIRECTORY_SEPARATOR . 'log.txt';

        $request = Yii::$app->request;
        $data = $request->post('data');

        $data_all_arr = explode(PHP_EOL, $data);

        foreach ($data_all_arr as $data_str)
        {
//            file_put_contents($file, $data_str, FILE_APPEND);
//            file_put_contents($file, PHP_EOL, FILE_APPEND);

            $data_arr = explode('|', $data_str);

            if (count($data_arr) < 3) continue;

            $message_type = (int) $data_arr[0];
            $user_id = (int) $data_arr[1];
            $event_date = $data_arr[2];
            $message_code = $data_arr[3];

            $model = new Message();
            $model->uid = $user_id;
            $model->type = $message_type;
            if ($message_type==1)
            {
                $model->body = 'Дата тестирования: ' . date('d-m-Y H:i:s', $event_date);
            }
            $model->created = time();
            $model->updated = time();
            $model->status = 1;
//            $model->appl_id
            $model->date = $event_date;
            $model->code = $message_code;
            if ($model->save()) Yii::$app->response->statusCode = 201;

//            $m = Message::findOne($model->id);
        }
    }
}