<?php

namespace common\modules\schedule\controllers;

use common\modules\employee\models\Employee;
use common\modules\schedule\models\AppointmentManager;
use common\modules\schedule\models\BaseSchedules;
use common\modules\schedule\models\BaseSchedulesDays;
use common\modules\userInterface\models\UserInterface;
use Yii;
use common\modules\schedule\models\Appointment;
use common\modules\schedule\models\AppointmentSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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

    public function actionIndex($doctor_ids='all',$start_date='now',$duration=AppointmentManager::DURATION_SIX_DAYS)
    {
        if ($doctor_ids==='all'){
            $doctor_ids=array_keys(BaseSchedules::getActiveDoctorsList());
        }

        if (is_int($doctor_ids)){
            $id=$doctor_ids;
            $doctor_ids=[$id];
        }

        $appointmentManager=AppointmentManager::getAppointmentsDaysForDoctors($doctor_ids,$start_date,$duration);
//        UserInterface::getVar($appointmentManager);
        return $this->render('index',[
            'appointmentManager'=>$appointmentManager
        ]);

    }

    /**
     * Lists all Appointment models.
     * @return mixed
     */
    public function actionEdit()
    {
        $searchModel = new AppointmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('edit', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
    public function actionCreate($appointment_day_id,$doctor_id,$date,$time)
    {
        $model = new Appointment();
        $model->NachNaz=date('H:i',$time);
        $appointment_day=BaseSchedulesDays::getAppointmentsDayForDoctor($doctor_id, $time);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->Id]);
        }

        return $this->render('create', [
            'model' => $model,
            'appointment_day'=>$appointment_day,
        ]);
    }

    /**
     * Updates an existing Appointment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->Id]);
        }

        return $this->render('update', [
            'model' => $model,
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
        $this->findModel($id)->delete();

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
}