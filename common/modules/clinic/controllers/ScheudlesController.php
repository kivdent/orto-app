<?php

namespace common\modules\clinic\controllers;

use common\modules\userInterface\models\UserInterface;
use Yii;
use common\modules\clinic\models\ClinicSchedleForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\modules\clinic\models\DaysInClinicSheudles;
use yii\base\Model;

/**
 * SheudlesController implements the CRUD actions for ClinicSchedleForm model.
 */
class ScheudlesController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
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
     * Lists all ClinicSchedleForm models.
     * @return mixed
     */
    public function actionIndex($clinic_id) {
        $dataProvider = new ActiveDataProvider([
            'query' => ClinicSchedleForm::find()->where('clinic_id=:id', [':id' => $clinic_id]),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'clinic_id' => $clinic_id,
        ]);
    }

    /**
     * Displays a single ClinicSchedleForm model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ClinicSchedleForm model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($clinic_id) {
        $model = new ClinicSchedleForm();

        $model->clinic_id = $clinic_id;
        $model->createEmptyDays();
        
        if ($model->load(Yii::$app->request->post())&&
                Model::loadMultiple($model->days, Yii::$app->request->post()) 
                && Model::validateMultiple($model->days)) {
           
            if ($model->save()) {

                return $this->redirect(['index', 'clinic_id' => $model->clinic_id]);
            }
        }
        $model->start_date = date("d.m.Y");
        
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing ClinicSchedleForm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) &&
                Model::loadMultiple($model->days, Yii::$app->request->post()) 
                && Model::validateMultiple($model->days) && $model->save()) {
            return $this->redirect(['index', 'clinic_id' => $model->clinic_id]);
        }
        
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing ClinicSchedleForm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionInactivate($id) {
        $model = $this->findModel($id);
        $model->status = $model->status ? $model::STATUS_INACTIVE : $model::STATUS_ACTIVE;
        if ($model->save()) {
            return $this->redirect(['index', 'clinic_id' => $model->clinic_id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ClinicSchedleForm model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $clinic_id = $model->clinic_id;
        $model->delete();

        return $this->redirect(['index', 'clinic_id' => $clinic_id]);
    }

    /**
     * Finds the ClinicSchedleForm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClinicSchedleForm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ClinicSchedleForm::findOne($id)) !== null) {

            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }

}
