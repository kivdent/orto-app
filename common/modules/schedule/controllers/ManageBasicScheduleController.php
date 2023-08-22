<?php

namespace common\modules\schedule\controllers;

use common\modules\schedule\models\BaseSchedulesDays;

use common\modules\userInterface\models\UserInterface;
use Yii;
use common\modules\schedule\models\BaseSchedules;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\modules\schedule\models\forms\BaseScheduleForm;

/**
 * ManageBasicScheduleController implements the CRUD actions for BaseSchedules model.
 */
class ManageBasicScheduleController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [],
                        'roles' => ['admin', 'director'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all BaseSchedules models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => BaseSchedules::find(),
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new BaseSchedules model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BaseScheduleForm();
        $model->setStartValues();
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//
//        }
//        print_r($model->errors);die();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (BaseSchedulesDays::loadMultiple($model->scheduleDays, Yii::$app->request->post())
                && BaseSchedulesDays::validateMultiple($model->scheduleDays)) {
                $model->save();
                foreach ($model->scheduleDays as $scheduleDay){
                    $scheduleDay->raspis_pack=$model->id;
                    $scheduleDay->save(false);
                }

                return $this->redirect(['index']);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing BaseSchedules model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (BaseSchedulesDays::loadMultiple($model->scheduleDays, Yii::$app->request->post())
                && BaseSchedulesDays::validateMultiple($model->scheduleDays)) {
//                UserInterface::getVar($model);
                $model->save();

                foreach ($model->scheduleDays as $scheduleDay){
                    $scheduleDay->save(false);
                }

                return $this->redirect(['index']);
            }
        }


        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BaseSchedules model.
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
     * Finds the BaseSchedules model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BaseSchedules the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = BaseSchedules::findOne($id);

        if (isset($model)) {
            return $model;
        } else throw new NotFoundHttpException('Невозможно найти страницу.');
    }

    private function findModelForm($id)
    {
        $model = BaseScheduleForm::findOne($id);

        if (isset($model)) {
            return $model;
        } else throw new NotFoundHttpException('Невозможно найти страницу.');
    }
}
