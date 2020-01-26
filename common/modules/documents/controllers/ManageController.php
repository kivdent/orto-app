<?php

namespace common\modules\documents\controllers;

use Yii;
use common\modules\documents\models\Notes;
use common\modules\documents\models\NotesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ManageController implements the CRUD actions for Notes model.
 */
class ManageController extends Controller
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

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $this->layout = '@frontend/views/layouts/light';
        if (Yii::$app->request->get('patient_id') !== null) {
            Yii::$app->userInterface->params['patient_id'] = Yii::$app->request->get('patient_id');

        }
        return true; // or false to not run the action
    }

    /**
     * Lists all Notes models.
     * @return mixed
     */
    public function actionIndex($patient_id)
    {
        $searchModel = new NotesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $patient_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Notes model.
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
     * Print a single Notes model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPrint($id)
    {
        $this->layout = '@frontend/views/layouts/print';
        return $this->render('print', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Notes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type)
    {
        $model = new Notes();
        $model->author_id = Yii::$app->user->id;
        $model->patient_id = Yii::$app->userInterface->params['patient_id'];
        $model->type = $type;
        $model->title = Notes::getTypesList()[$type];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view',
                'id' => $model->id,
                'patient_id' => $model->patient_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'type' => $type,
        ]);
    }

    /**
     * Updates an existing Notes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view',
                'id' => $model->id, 'patient_id' => $model->patient_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Notes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index','patient_id'=>Yii::$app->userInterface->params['patient_id']]);
    }

    /**
     * Finds the Notes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notes::findOne($id)) !== null) {
            if (!isset(Yii::$app->userInterface->params['patient_id'])) {
                Yii::$app->userInterface->params['patient_id']=$model->patient_id;
            }
            return $model;
        }

        throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
    }
}
