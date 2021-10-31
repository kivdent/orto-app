<?php

namespace common\modules\schedule\controllers;

use common\modules\schedule\models\BaseSchedules;
use common\modules\schedule\models\BaseSchedulesDays;
use common\modules\schedule\models\ScheduleManager;
use common\modules\userInterface\models\UserInterface;
use Yii;
use common\modules\schedule\models\AppointmentsDay;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ScheduleController implements the CRUD actions for AppointmentsDay model.
 */
class ScheduleController extends Controller
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

    /**
     * Lists all AppointmentsDay models.
     * @param string $start_date
     * @return mixed
     */
    public function actionIndex($start_date = 'now')
    {
        $start_date = strtotime($start_date);
        $scheduleManager = new ScheduleManager(['start_date' => $start_date]);
        return $this->render('index', [
            'scheduleManager' => $scheduleManager,
        ]);
    }

    /**
     * Displays a single AppointmentsDay model.
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
     * Creates a new AppointmentsDay model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param string $date
     * @param string $doctor_id
     * @return mixed
     */
    public function actionCreate($date = 'now', $doctor_id = 'all')
    {
        if ($date == 'now') {
            $date = strtotime('now');
        }
        $disabled = $doctor_id == 'all' ? false : true;
        $doctor_id = Yii::$app->request->post('AppointmentsDay')['vrachID'] ? Yii::$app->request->post('AppointmentsDay')['vrachID'] : $doctor_id;
        $date = Yii::$app->request->post('AppointmentsDay')['date'] ? strtotime(Yii::$app->request->post('AppointmentsDay')['date']) : $date;

        if ($doctor_id == 'all') {
            $model = new AppointmentsDay([
                'date' => date('d.m.Y', $date),
                'vrachID' => $doctor_id,
                'Nach' => '09:00:00',
                'Okonch' => '20:00:00',
                'TimePat' => 15,
                'vih'=>0
            ]);
        } else {
            $model = BaseSchedulesDays::getAppointmentsDayForDoctor($doctor_id, $date);
            $model->date = date('d.m.Y', strtotime($model->date));
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'start_date' => '1.' . date('m.Y', $date)]);
        }

        return $this->render('create', [
            'model' => $model,
            'disabled' => $disabled
        ]);
    }

    /**
     * Updates an existing AppointmentsDay model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->date = date('d.m.Y', strtotime($model->date));
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        }

        return $this->render('update', ['model' => $model, 'disabled' => true]);
    }

    /**
     * Deletes an existing AppointmentsDay model.
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
     * Finds the AppointmentsDay model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AppointmentsDay the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AppointmentsDay::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
