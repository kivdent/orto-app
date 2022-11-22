<?php

namespace common\modules\schedule\controllers;

use common\components\SmsNotifier;
use common\modules\catalogs\models\NoticeResult;
use common\modules\notifier\assets\NotifierAsset;
use common\modules\schedule\models\Appointment;
use common\modules\schedule\models\AppointmentManager;
use common\modules\schedule\models\BaseSchedules;
use common\modules\userInterface\models\UserInterface;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Response;

class RecorderController extends \yii\web\Controller
{
    const PRESENCE_CHANGE = 'change';
    const PRESENCE_NOT_CHANGE = 'not_change';

    const ELEMENT_SHOW = 'show';
    const ELEMENT_HIDE = 'hide';


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [],
                        'roles' => ['admin', 'recorder', 'senior_recorder',],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['doctor-index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($start_date = 'now')
    {
        $start_date = 'now' ? date('d.m.Y') : $start_date;
        $doctor_ids = array_keys(BaseSchedules::getActiveDoctorsList());
        $appointmentManager = AppointmentManager::getAppointmentsDaysForDoctors($doctor_ids, date('d.m.Y'), AppointmentManager::DURATION_ONE_DAY);
        return $this->render('index', [
            'appointmentManager' => $appointmentManager,
            'start_date' => $start_date,
            'options' => [
                'doctor_chooser' => self::ELEMENT_SHOW,
                'full_table_chooser' => self::ELEMENT_SHOW,

            ],
        ]);
    }

    public function actionDoctorIndex($start_date = 'noe')
    {
        $start_date = 'now' ? date('d.m.Y') : $start_date;
        $doctor_ids = [Yii::$app->user->identity->employe_id];
        $appointmentManager = AppointmentManager::getAppointmentsDaysForDoctors($doctor_ids, date('d.m.Y'), AppointmentManager::DURATION_ONE_DAY);
        return $this->render('index', [
            'appointmentManager' => $appointmentManager,
            'start_date' => $start_date,
            'options' => [
                'doctor_chooser' => self::ELEMENT_HIDE,
                'full_table_chooser' => self::ELEMENT_SHOW,

            ]
        ]);
    }

    function actionGetPresenceStatus()
    {
        $response = ['html' => ''];
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $appointment = Appointment::findOne(Yii::$app->request->post('appointment_id'));
            $change = Yii::$app->request->post('change');

            if ($appointment->Yavka === Appointment::PRESENCE_STATUS_NOT_APPEARED) {
                if ($change == self::PRESENCE_CHANGE) {
                    $appointment->Yavka = Appointment::PRESENCE_STATUS_APPEARED;
                    $appointment->save(false);
                    $response = ['html' => Html::button('Начало',
                        [
                            'class' => 'btn btn-xs btn-warning btn-presence',
                            'title' => 'Отметить начало приёма',
                            'id' => Yii::$app->request->post('appointment_id'),
                        ])];
                } else {
                    $response = ['html' => Html::button('Явка',
                        [
                            'class' => 'btn btn-xs btn-success btn-presence',
                            'title' => 'Отметить явку пациента',
                            'id' => Yii::$app->request->post('appointment_id'),
                        ])];
                }
            } elseif ($appointment->AppointmentPresence()) {
                if ($change == self::PRESENCE_CHANGE) {
                    $appointment->NachPr = date('H:i:s');
                    $appointment->save(false);
                    $response = ['html' => Html::button('Окончание',
                        [
                            'class' => 'btn btn-xs btn-danger btn-presence',
                            'title' => 'Отметить окнчание приёма',
                            'id' => Yii::$app->request->post('appointment_id'),
                        ])];
                } else {
                    $response = ['html' => Html::button('Начало',
                        [
                            'class' => 'btn btn-xs btn-warning btn-presence',
                            'title' => 'Отметить начало приёма',
                            'id' => Yii::$app->request->post('appointment_id'),
                        ])];
                }
            } elseif ($appointment->AppointmentStarted()) {
                if ($change == self::PRESENCE_CHANGE) {
                    $appointment->OkonchPr = date('H:i:s');
                    $appointment->save(false);
                    $response = ['html' => Html::button('Приём окончен',
                        [
                            'class' => 'btn btn-xs btn-success btn-presence',
                            'title' => 'Приём окончен',
                            'id' => Yii::$app->request->post('appointment_id'),
                            'disabled' => 'disabled'
                        ])];
                } else {
                    $response = ['html' => Html::button('Окончание',
                        [
                            'class' => 'btn btn-xs btn-danger btn-presence',
                            'title' => 'Отметить окнчание приёма',
                            'id' => Yii::$app->request->post('appointment_id'),
                        ])];
                }
            } elseif ($appointment->AppointmentStopped()) {
                $response = ['html' => Html::button('Приём окончен',
                    [
                        'class' => 'btn btn-xs btn-success btn-presence',
                        'title' => 'Приём окончен',
                        'id' => Yii::$app->request->post('appointment_id'),
                        'disabled' => 'disabled'
                    ])];
            }
        }
        return $response;
    }

    function actionGetNoticeResult()
    {
        $response = ['html' => ''];
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $appointment = Appointment::findOne(Yii::$app->request->post('appointment_id'));
            $response = ['html' => $this->getHTML($appointment)];
        }
        return $response;
    }

    function actionSetNoticeResult()
    {
        $response = ['html' => ''];
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $appointment = Appointment::findOne(Yii::$app->request->post('appointment_id'));
            $noticeResult = Yii::$app->request->post('notice_result');
            $appointment->RezObzv = $noticeResult;
            $appointment->save(false);
            if ($appointment->RezObzv == NoticeResult::NOTICE_RESULT_SMS_SENT) SmsNotifier::sendAppointmentNotification($appointment->Id);
            $response = ['html' => $this->getHTML($appointment)];
        }
        return $response;
    }

    protected function getHTML(Appointment $appointment)
    {
        $html = Html::dropDownList('notice-result', $appointment->RezObzv, Appointment::GetNoticeList(),
            [
                'class' => 'form-control notice-result-select'
            ]);
        return $html;
    }
}
