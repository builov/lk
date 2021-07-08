<?php
namespace backend\controllers;

use backend\models\SendEmailForm;
use common\models\Message;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'email'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionEmail($code)
    {
//        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            return $this->goBack();
//        }

        if (Yii::$app->request->post())
        {
            $data = new SendEmailForm();
            $data->load(Yii::$app->request->post());

            $user = User::findOne($data->uid);
            $message = Message::findOne($data->message_id);
            $mid = $message->id;

//            print_r($message);

            $subj = 'Сообщение от Приемной комиссии';
            $data = [];
//            $data['course'] = $course_name;
            $data['datetime'] = date('d-m-Y H:i', $message->date);

            if ($user->sendEmail($message, $subj, $data))
            {
                //$message = Message::findOne($mid);
                $message->sent = 1;
                if ($message->save()) Yii::$app->session->setFlash('success', 'Сообщение успешно отправлено.');
            }
//            var_dump($result);
        }

        $form = new SendEmailForm();
        $messages = Message::find()->select('id,uid,code,created,date')->where(['code' => $code, 'sent' => 0])->asArray()->all();

        return $this->render('email', [
            'messages' => $messages,
            'form_model' => $form
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
