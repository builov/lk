<?php


namespace frontend\controllers;


use common\models\Application;
use common\models\Comment;
use Yii;
use yii\web\Controller;

class TransmitController extends Controller
{
    public function actionMessage()
    {
        $request = Yii::$app->request;
        $data = $request->post('data');

        $file = Yii::$app->params['uploadDir'] . DIRECTORY_SEPARATOR . 'log.txt';
        file_put_contents($file, $data);

//        $data_all_arr = explode(PHP_EOL, $data);
//
//        foreach ($data_all_arr as $data_str)
//        {
//            $data_arr = explode('|', $data_str);
//
//            if (count($data_arr) < 3) continue;
//
//            $status = $data_arr[0];
//            $application_id = (int) $data_arr[1];
//            $comment_text = $data_arr[2];
//
//
//            if (in_array($status, ['3','4', '5']) && $application_id)
//            {
//                if ($application = Application::findOne($application_id))
//                {
//                    $application->status = $status;
//                    $application->updated = time();
//                    $application->show_message = 1;
//                    $application->save();
//
//                    if ($status=='3') //для статуса "заявка отклонена"
//                    {
//                        $comment = new Comment();
//                        $comment->appl_id = $application_id;
//                        $comment->body = $comment_text;
//                        $comment->created = time();
//                        $comment->save();
//                    }
//
//                }
//            }
//        }
    }
}