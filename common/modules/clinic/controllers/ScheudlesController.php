<?php

namespace common\modules\clinic\controllers;

use Yii;
use common\modules\clinic\models\ClinicSheudles;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SheudlesController implements the CRUD actions for ClinicSheudles model.
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
     * Lists all ClinicSheudles models.
     * @return mixed
     */
    public function actionIndex($clinic_id) {
        $dataProvider = new ActiveDataProvider([
            'query' => ClinicSheudles::find()->where('clinic_id=:id', [':id' => $clinic_id]),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'clinic_id' => $clinic_id,
        ]);
    }

    /**
     * Displays a single ClinicSheudles model.
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
     * Creates a new ClinicSheudles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($clinic_id) {
        $model = new ClinicSheudles();

        $model->clinic_id = $clinic_id;
//        
//        if ($model->load(Yii::$app->request->post())){
//          $model->start_date=Yii::$app->formatter->asDate($model->start_date, 'php:Y-m-d');
//           echo "<pre>";
//        print_r($model);
//        echo "</pre>"; die();
        //}
        
        if ($model->load(Yii::$app->request->post())) {
            if( $model->save()){  
                
            return $this->redirect(['index', 'clinic_id' => $model->clinic_id]);
            }
        }
 $model->start_date=date("d.m.Y");
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing ClinicSheudles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'clinic_id' => $model->clinic_id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }
 /**
     * Updates an existing ClinicSheudles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionInactivate($id) {
        $model = $this->findModel($id);
       $model->status=$model->status? $model::STATUS_INACTIVE:$model::STATUS_ACTIVE;
        if ($model->save()) {
            return $this->redirect(['index', 'clinic_id' => $model->clinic_id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }
    /**
     * Deletes an existing ClinicSheudles model.
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
     * Finds the ClinicSheudles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClinicSheudles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ClinicSheudles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
