<?php

namespace common\modules\schedule\controllers;

use common\modules\schedule\models\TimeSheetManager;
use Yii;
use common\modules\schedule\models\TimeSheet;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TimeSheetController implements the CRUD actions for TimeSheet model.
 */
class TimeSheetController extends Controller
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
     * Lists all TimeSheet models.
     * @param string $start_date
     * @return mixed
     */
    public function actionIndex($start_date = 'now')
    {
        $start_date = strtotime(date('01.m.Y', strtotime($start_date)));
        $timeSheetManager = new TimeSheetManager([
            'startDate' => $start_date
        ]);

        return $this->render('index', [
            'timeSheetManager' => $timeSheetManager,
        ]);
    }

    /**
     * Displays a single TimeSheet model.
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
     * Creates a new TimeSheet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $date
     * @param $employee_id
     * @return mixed
     */
    public function actionCreate($date,$employee_id)
    {
        $model = new TimeSheet([
            'date' => date('Y-m-d',$date),
            'sotr' => $employee_id
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TimeSheet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TimeSheet model.
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
     * Finds the TimeSheet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TimeSheet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TimeSheet::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionIn($employee_id)
    {
        $timeSheet = new TimeSheet([
            'date' => date('Y-m-d'),
            'in' => date('h:i:s'),
            'out' => '00:00:00',
            'sotr' => $employee_id,
        ]);
        $timeSheet->save(false);
        return $this->redirect(['index']);
    }

    public function actionOut($id)
    {
        $timeSheet = $this->findModel($id);
        $timeSheet->out = date('h:i:s');
        $timeSheet->save(false);
        return $this->redirect(['index']);
    }
}
