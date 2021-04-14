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
        return '
[{"programs":{"appl18":{"program3":"Сестринское дело очно-заочная, после 11 кл., договор"},"appl19":{"program4":"Лечебное дело, после 11 кл., очно, договор"},"appl29":{"program4":"Лечебное дело, после 11 кл., очно, договор"},"appl30":{"program4":"Лечебное дело, после 11 кл., очно, договор"},"appl31":{"program4":"Лечебное дело, после 11 кл., очно, договор"},"appl32":{"program4":"Лечебное дело, после 11 кл., очно, договор"},"appl33":{"program4":"Лечебное дело, после 11 кл., очно, договор"},"appl34":{"program4":"Лечебное дело, после 11 кл., очно, договор"},"appl35":{"program4":"Лечебное дело, после 11 кл., очно, договор"},"appl36":{"program4":"Лечебное дело, после 11 кл., очно, договор"},"appl37":{"program4":"Лечебное дело, после 11 кл., очно, договор"},"appl38":{"program4":"Лечебное дело, после 11 кл., очно, договор"},"appl39":{"program4":"Лечебное дело, после 11 кл., очно, договор"}},"program_base":"2","program_type":"очно-заочно","program_financing":"договор","user_id":69,"user_email":"builov@inbox.ru","user_lastname":"Буйлов","user_firstname":"Дмитрий","user_patronim":"","user_birthdate":"1970-09-24","user_region":4,"user_snils":"","user_gender":"Мужской","user_education_level":5,"user_institution":"ПТУ №1","user_graduate_year":2020,"user_certificate_series":"","user_certificate_number":"1234567","user_passport_series":"","user_passport_number":"234234","user_passport_issued":"УВД","user_passport_code":"","user_passport_date":"2020-11-11","user_address_passport":"121108, г. Москва, ул. Пивченкова, дом 12, квартира 31","user_address_current":"121108, г. Москва, ул. Пивченкова, дом 12, квартира 31","user_phone":"+7 (123) 123-12-31","user_files":["https:\/\/lks.medcollege7.ru\/uploads\/user69_passport.pdf","https:\/\/lks.medcollege7.ru\/uploads\/user69_education.pdf"]},{"programs":{"appl20":{"program5":"Лечебное дело, после 11 кл., очно, бюджет"}},"program_base":"2","program_type":"очно","program_financing":"бюджет","user_id":70,"user_email":"aat.86@mail.ru","user_lastname":"Петров","user_firstname":"Гадя","user_patronim":"Хренова","user_birthdate":"1250-08-04","user_region":2,"user_snils":"123-654-789-62","user_gender":"Мужской","user_education_level":2,"user_institution":"87654321","user_graduate_year":2021,"user_certificate_series":"оывгшывр","user_certificate_number":"0140101010101","user_passport_series":"10 10","user_passport_number":"111111","user_passport_issued":"ОНИ","user_passport_code":"020-202","user_passport_date":"0000-00-00","user_address_passport":"357903, край. Ставропольский, р-н. Советский, с. Отказное, ул. Зиг-Заг, дом 2, квартира ","user_address_current":"357903, край. Ставропольский, р-н. Советский, с. Отказное, ул. Зиг-Заг, дом 2, квартира ","user_phone":"+7 (800) 700-25-25","user_files":["https:\/\/lks.medcollege7.ru\/uploads\/user70_passport.pdf","https:\/\/lks.medcollege7.ru\/uploads\/user70_education.pdf"]},{"programs":{"appl21":{"program5":"Лечебное дело, после 11 кл., очно, бюджет"}},"program_base":"2","program_type":"очно","program_financing":"бюджет","user_id":72,"user_email":"mi96omel@yandex.ru","user_lastname":"Омельченко ","user_firstname":"Михаил ","user_patronim":"Сергеевич","user_birthdate":"1996-10-05","user_region":2,"user_snils":"213-214-324-32","user_gender":"Мужской","user_education_level":3,"user_institution":"РАНХиГС","user_graduate_year":2019,"user_certificate_series":"123123412","user_certificate_number":"123123123","user_passport_series":"46 11","user_passport_number":"123214","user_passport_issued":"ТП 3","user_passport_code":"181-170","user_passport_date":"2016-02-11","user_address_passport":"141170, обл. Московская, рп. Монино, г. Щёлково, ул. Маршала Красовского, дом 8, квартира 13","user_address_current":"141170, обл. Московская, рп. Монино, г. Щёлково, ул. Маршала Красовского, дом 8, квартира 13","user_phone":"+7 (963) 638-35-25","user_files":["https:\/\/lks.medcollege7.ru\/uploads\/user72_passport.pdf","https:\/\/lks.medcollege7.ru\/uploads\/user72_education.pdf"]},{"programs":{"appl22":{"program4":"Лечебное дело, после 11 кл., очно, договор"}},"program_base":"2","program_type":"очно","program_financing":"договор","user_id":75,"user_email":"kapichnikov@medcollege7.ru","user_lastname":"Капичников","user_firstname":"Евгений","user_patronim":"Витальевич","user_birthdate":"1993-08-31","user_region":1,"user_snils":"123-123-123-12","user_gender":"Мужской","user_education_level":5,"user_institution":"Школа № 428","user_graduate_year":2009,"user_certificate_series":"4023140009","user_certificate_number":"1233210001","user_passport_series":"45 12","user_passport_number":"666123","user_passport_issued":"ОТДЕЛОМ УФМС ГОНДУРАСА ПО ЗАПАДНОМУ ПОЛУШАРИЮ ПО ГОР. ТЕГУСИГАЛЬПА ПО РАЙОНУ ЭЛЬ ТАБЛОН","user_passport_code":"444-555","user_passport_date":"1999-02-01","user_address_passport":"Tegucigalpa, Гондурас, дом 33, квартира 1","user_address_current":"Tegucigalpa, Гондурас, дом 33, квартира 1","user_phone":"+7 (916) 509-81-98","user_files":["https:\/\/lks.medcollege7.ru\/uploads\/user75_passport.pdf","https:\/\/lks.medcollege7.ru\/uploads\/user75_education.pdf"]},{"programs":{"appl23":{"program3":"Сестринское дело очно-заочная, после 11 кл., договор"}},"program_base":"2","program_type":"очно-заочно","program_financing":"договор","user_id":77,"user_email":"prog1@medcollege7.ru","user_lastname":"Андержанов","user_firstname":"Ирфан","user_patronim":"Хайдярович","user_birthdate":"2020-04-04","user_region":1,"user_snils":"543-876-588-43","user_gender":"Мужской","user_education_level":4,"user_institution":"Крематорий","user_graduate_year":1990,"user_certificate_series":"355рпа5","user_certificate_number":"5567654","user_passport_series":"43 67","user_passport_number":"566543","user_passport_issued":"Структурой кгб","user_passport_code":"123-456","user_passport_date":"2020-12-25","user_address_passport":"143090, обл. Московская, г. Краснознаменск, гск. Авто Кунцево, дом 1, квартира 4","user_address_current":"143090, обл. Московская, г. Краснознаменск, гск. Авто Кунцево, дом 1, квартира 4","user_phone":"+7 (432) 146-78-86","user_files":["https:\/\/lks.medcollege7.ru\/uploads\/user77_passport.pdf","https:\/\/lks.medcollege7.ru\/uploads\/user77_education.pdf"]},{"programs":{"appl24":{"program3":"Сестринское дело очно-заочная, после 11 кл., договор"},"appl25":{"program4":"Лечебное дело, после 11 кл., очно, договор"}},"program_base":"2","program_type":"очно-заочно","program_financing":"договор","user_id":79,"user_email":"grechinad@yandex.ru","user_lastname":"Гречина","user_firstname":"Надежда","user_patronim":"Николаевна","user_birthdate":"1959-02-03","user_region":1,"user_snils":"001-391-840-05","user_gender":"Женский","user_education_level":3,"user_institution":"СОШ пос. Пионерский Тюменской области","user_graduate_year":1975,"user_certificate_series":"А","user_certificate_number":"363636","user_passport_series":"45 07","user_passport_number":"215045","user_passport_issued":"ОВД Ярославского района  города Москвы","user_passport_code":"770-106","user_passport_date":"2004-02-20","user_address_passport":"111674, г. Москва, ул. Палехская, дом 21, квартира 98","user_address_current":"111674, г. Москва, ул. Палехская, дом 21, квартира 98","user_phone":"+7 (896) 712-10-53","user_files":["https:\/\/lks.medcollege7.ru\/uploads\/user79_passport.pdf","https:\/\/lks.medcollege7.ru\/uploads\/user79_education.pdf"]},{"programs":{"appl26":{"program1":"Сестринское дело, после 9 кл., очно, договор"}},"program_base":"1","program_type":"очно","program_financing":"договор","user_id":80,"user_email":"adzhiablaeva@medcollege7.ru","user_lastname":"Гончарова","user_firstname":"Инна","user_patronim":"Алексеевна","user_birthdate":"2005-03-23","user_region":1,"user_snils":"145-164-431-23","user_gender":"Женский","user_education_level":1,"user_institution":"ГБОУ СОШ № 1234","user_graduate_year":2021,"user_certificate_series":"","user_certificate_number":"77018001421043","user_passport_series":"45 02","user_passport_number":"145326","user_passport_issued":"МВД России по району Раменки гор. Москвы","user_passport_code":"772-154","user_passport_date":"2019-04-09","user_address_passport":"123181, г. Москва, ул. Исаковского, дом 6 корпус 1, квартира 123","user_address_current":"123181, г. Москва, ул. Исаковского, дом 6 корпус 1, квартира 123","user_phone":"+7 (890) 361-11-49","user_files":["https:\/\/lks.medcollege7.ru\/uploads\/user80_passport.pdf","https:\/\/lks.medcollege7.ru\/uploads\/user80_education.pdf"]},{"programs":{"appl27":{"program3":"Сестринское дело очно-заочная, после 11 кл., договор"},"appl28":{"program4":"Лечебное дело, после 11 кл., очно, договор"}},"program_base":"2","program_type":"очно-заочно","program_financing":"договор","user_id":81,"user_email":"uliad1@yandex.ru","user_lastname":"Дирдина","user_firstname":"Юлия","user_patronim":"Анатольевна","user_birthdate":"2001-05-27","user_region":1,"user_snils":"999-999-999-99","user_gender":"Женский","user_education_level":2,"user_institution":"sdgfsdfg","user_graduate_year":2019,"user_certificate_series":"-","user_certificate_number":"99999999999999999999","user_passport_series":"43 43","user_passport_number":"343425","user_passport_issued":"ывапывап","user_passport_code":"123-123","user_passport_date":"2020-12-20","user_address_passport":"111674, г. Москва, пр-кт. Зелёный, дом 23\/43, квартира 1","user_address_current":"111674, г. Москва, пр-кт. Зелёный, дом 23\/43, квартира 1","user_phone":"+7 (324) 213-41-23","user_files":["https:\/\/lks.medcollege7.ru\/uploads\/user81_passport.pdf","https:\/\/lks.medcollege7.ru\/uploads\/user81_education.pdf"]}]';
    }
}