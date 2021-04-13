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
            $response_body[] = 'u' . $model->uid;
        }
//        return implode("|", $response_body);
        return $response_body;
    }
}