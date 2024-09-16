<?php

namespace common\modules\schedule\controllers;

use common\modules\employee\models\Employee;
use common\modules\patient\models\Patient;
use common\modules\schedule\models\AppointmentContent;
use common\modules\schedule\models\AppointmentManager;
use common\modules\schedule\models\AppointmentsDay;
use common\modules\schedule\models\BaseSchedules;
use common\modules\schedule\models\BaseSchedulesDays;
use common\modules\userInterface\models\UserInterface;
use Exception;
use Yii;
use common\modules\schedule\models\Appointment;
use common\modules\schedule\models\AppointmentSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * AppointmentController implements the CRUD actions for Appointment model.
 */
class AppointmentController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
//    public function beforeAction($action)
//    {
//        if (!parent::beforeAction($action)) {
//            return false;
//        }
//
//        $this->layout = '@frontend/views/layouts/light_fluid';
//        return true; // or false to not run the action
//    }
    public function actionIndex($doctor_ids = AppointmentManager::DOCTOR_IDS_ALL, $start_date = 'now', $duration = AppointmentManager::DURATION_SIX_DAYS, $patient_id = null, $full_table = true)
    {
        if ($start_date == "now") {
            $start_date = date('d.m.Y', strtotime($start_date));
        }
        $this->layout = '@frontend/views/layouts/light_fluid';
//        if (UserInterface::UserRoleIsDoctor()){
//            $doctor_ids=UserInterface::getEmployeeId();
//        }
        if ($doctor_ids === AppointmentManager::DOCTOR_IDS_ALL) {
            $doctor_ids = array_keys(BaseSchedules::getActiveDoctorsList());
            $doctor_id = AppointmentManager::DOCTOR_IDS_ALL;
        } else {
            $id = $doctor_ids;
            $doctor_ids = [$id];
            $doctor_id = $id;
        }


        $doctor_ids = array_keys(BaseSchedules::getActiveDoctorsList());

        $appointmentManager = AppointmentManager::getAppointmentsDaysForDoctors($doctor_ids, $start_date, $duration);
        // UserInterface::getVar($appointmentManager);
        return $this->render('index', [
            'appointmentManager' => $appointmentManager,
            'doctor_id' => $doctor_id,
            'patient_id' => $patient_id,
            'full_table' => $full_table,
            'start_date' => $start_date,
            'duration' => $duration,
        ]);
    }

    /**
     * Lists all Appointment models.
     * @return mixed
     */
//    public function actionEdit()
//    {
//        $searchModel = new AppointmentSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('edit', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }

    public function actionCancel($appointmentId)
    {
        $appointment = Appointment::findOne($appointmentId);
        $appointment->status = ($appointment->status == Appointment::STATUS_ACTIVE) ? Appointment::STATUS_CANCEL : Appointment::STATUS_ACTIVE;
        $appointment->save(false);
        Yii::$app->session->setFlash('success', 'Пациент отменён');
        return $this->redirect('index');
    }

    /**
     * Displays a single Appointment model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Appointment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     *
     */
    public function actionCreate($appointment_day_id, $doctor_id, $date, $time, $patient_id = null)
    {
        $model = new Appointment();
        $model->NachNaz = date('H:i', $time);
        $model->Perv = 0;
        $model->SoderzhNaz = 1;
        $model->RezObzv = 55555;
        $model->Yavka = 0;
        $model->NachPr = '00:00:00';
        $model->OkonchPr = '00:00:00';
        if ($patient_id) {
            $model->PatID = $patient_id;
        }
        $appointment_day = BaseSchedulesDays::getAppointmentsDayForDoctor($doctor_id, $time);
//        $model->validate();
//        UserInterface::getVar($model->getErrors());
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            UserInterface::getVar(Yii::$app->request->post());
            $transaction = Appointment::getDb()->beginTransaction();
            try {
                if ($appointment_day->isNewRecord) {
                    $appointment_day->save();
                }
                $model->dayPR = $appointment_day->id;

                $model->save();
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Пациент записан');
            } catch (\Throwable $e) {
                Yii::$app->session->setFlash('danger', 'Ошибка записи');
                $transaction->rollBack();
                throw $e;
            }

            return $this->redirect(['index',
                'start_date' => UserInterface::getFormatedDate($appointment_day->date),
                'doctor_ids' => $doctor_id,
            ]);
        }
        return $this->render('create', [
            'model' => $model,
            'appointment_day' => $appointment_day,
        ]);
    }

    /**
     * Updates an existing Appointment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $appointmentId
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($appointmentId)
    {
        $appointment = $this->findModel($appointmentId);
        $appointment_day = AppointmentsDay::findOne($appointment->dayPR);
        if ($appointment->load(Yii::$app->request->post()) && $appointment->save()) {
            return $this->redirect('index');
        }

        return $this->render('update', [
            'appointment' => $appointment,
            'appointment_day' => $appointment_day,
        ]);
    }

    /**
     * Deletes an existing Appointment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Appointment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Appointment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Appointment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function getHtmlGrid()
    {
        $html = '';
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $html = "";
        }
        return $html;
    }

    public function actionGetPatientName()
    {
        $name = '';
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            if ($patient = Patient::findOne(Yii::$app->request->post('patient_id'))) {
                return [
                    'fullName' => $patient->fullName
                ];
            } else {
                return 'error';
            }
        }
        return $name;
    }

    public function actionGetTimeListForNextAppointment()
    {
        $time_list = '';
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $doctor_id = Yii::$app->request->post('doctor_id');
            $endTime = Yii::$app->request->post('time');
            $time = strtotime(Yii::$app->request->post('date') . ' ' . $endTime . ':00');

            if ($time_list = AppointmentsDay::getTimeListForNextAppointment($doctor_id, $time, $endTime)) {
                return [
                    'time_list' => $time_list,
                ];
            } else {
                return 'error';
            }
        }
        return $time_list;
    }

    public function actionGetAppointmentDaySpecialization()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $doctor_id = Yii::$app->request->post('doctor_id');

            $date = strtotime(Yii::$app->request->post('date'));
            $appointmentDay = AppointmentsDay::getAppointmentsDayForDoctor($doctor_id, $date);

            return [
                'specializationAppointmentsDayLabel' => $appointmentDay->specializationAppointmentsDayLabel,
                'comment' => $appointmentDay->comment
            ];
        }
    }

    public
    function actionGetTimeListForAppointmentContent()
    {
        $list = '';
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            if ($list = AppointmentContent::getContentList()) {
                asort($list);
                return [
                    'list' => $list,
                ];
            } else {
                return 'error';
            }
        }
        return $list;
    }

    public
    function actionUpdateAppointment()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax) {
            $model = Appointment::findOne(Yii::$app->request->post('Appointment')['Id']);

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $model->save();
                return 'success';
            }
        }
    }

    public
    function actionSetAppointment()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax) {

            $model = new Appointment();
            $model->Perv = 0;
            $model->SoderzhNaz = 1;
            $model->RezObzv = 55555;
            $model->Yavka = 0;
            $model->NachPr = '00:00:00';
            $model->OkonchPr = '00:00:00';


            if ($model->load(Yii::$app->request->post()) && $model->validate()) {

                $appointment_day = BaseSchedulesDays::getAppointmentsDayForDoctor(Yii::$app->request->post('doctor_id'), strtotime(Yii::$app->request->post('date')));

//                if ($model->status == Appointment::STATUS_ACTIVE && $model->hasCrossTime()) {
//                    Yii::$app->session->setFlash('danger', 'Время занято');
//                    return 'error';
//                }

                $transaction = Appointment::getDb()->beginTransaction();
                try {
                    if ($appointment_day->isNewRecord) {

                        $appointment_day->save();
                    }
                    $model->dayPR = $appointment_day->id;

                    if (!$model->save()) throw new Exception('Ошибка записи');

                    $transaction->commit();

                    return $model->Id;

                } catch (\Throwable $e) {

                    $transaction->rollBack();
                    throw $e;
                    return 'error';
                }
            }
        }
        return "error";
    }

    public
    function actionGetDoctorName()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            return Employee::findOne(Yii::$app->request->post('doctor_id'))->fullName;
        }
    }

    public
    function actionCancelAppointment()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $appointment = Appointment::findOne(Yii::$app->request->post('appointment_id'));
            $appointment->status = ($appointment->status == Appointment::STATUS_ACTIVE) ? Appointment::STATUS_CANCEL : Appointment::STATUS_ACTIVE;
            if ($appointment->save()) {
                Yii::$app->session->setFlash('success', 'Пациент отменён');
                return 'success';
            } else {
                return 'error';
            }

        }
    }

    public
    function actionVue()
    {
        return $this->render('vue');
    }
}