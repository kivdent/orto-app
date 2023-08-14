<?php

namespace common\modules\clinic\controllers;

use Yii;
use common\modules\clinic\models\Workplaces;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * WorkplacesController implements the CRUD actions for Workplaces model.
 */
class WorkplacesController extends Controller {

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
     * Lists all Workplaces models.
     * @return mixed
     */
    public function actionIndex($clinic_id) {

        $dataProvider = new ActiveDataProvider([
            'query' => Workplaces::find()->where('clinic_id=:id', [':id' => $clinic_id])
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'clinic_id' => $clinic_id,
        ]);
    }

    /**
     * Displays a single Workplaces model.
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
     * Creates a new Workplaces model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($clinic_id) {
        $model = new Workplaces();
        
        $model->clinic_id=$clinic_id;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'clinic_id' => $model->clinic_id]);
        }
       
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Workplaces model.
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
     * Deletes an existing Workplaces model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model= $this->findModel($id);
        $clinic_id=$model->clinic_id;
       $model->delete();

        return $this->redirect(['index','clinic_id'=> $clinic_id]);
    }

    /**
     * Finds the Workplaces model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Workplaces the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Workplaces::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
