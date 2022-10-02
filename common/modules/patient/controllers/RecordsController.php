<?php

namespace common\modules\patient\controllers;

use common\modules\catalogs\models\Objectively;
use common\modules\patient\models\Operation;
use Yii;
use common\modules\patient\models\MedicalRecords;
use common\modules\patient\models\MedicalRecordsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * RecordsController implements the CRUD actions for MedicalRecords model.
 */
class RecordsController extends Controller
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
                        'actions' => ['delete'],
                        'roles' => ['admin',],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'update', 'create', 'get-objectively-form', 'print','print-all'],
                        'roles' => ['admin', 'therapist', 'orthopedist', 'surgeon', 'orthodontist', 'recorder', 'senior_nurse',],
                    ],
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
        return true; // or false to not run the action
    }

    /**
     * Lists all MedicalRecords models.
     * @return mixed
     */
    public function actionIndex($patient_id)
    {
        $searchModel = new MedicalRecordsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $patient_id);
        $medicalRecords=MedicalRecords::GetMedicalRecordsForPatient($patient_id);
        return $this->render('index', [
            'medicalRecords' => $medicalRecords,
        ]);
    }

    /**
     * Displays a single MedicalRecords model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        Yii::$app->userInterface->params['patient_id'] = $model->patient_id;
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new MedicalRecords model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($patient_id, $invoice_id = null)
    {
        $model = new MedicalRecords();
        $model->date = date('d.m.Y');
        $model->patient_id = $patient_id;
        $model->invoice_id = $invoice_id;
        $model->employe_id = Yii::$app->userInterface->employe_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'patient_id' => $patient_id,]);
        }

        return $this->render('create', [
            'model' => $model,

        ]);
    }

    /**
     * Updates an existing MedicalRecords model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     *
     */
    /* @var $userInterface \common\modules\userInterface\models\UserInterface */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        Yii::$app->userInterface->params['patient_id'] = $model->patient_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $model->date = Yii::$app->formatter->asDate($model->date, 'php:d.m.Y');
        if (!(($model->employe_id == Yii::$app->userInterface->employe_id) or (Yii::$app->userInterface->roleName == 'admin'))) {
            throw new HttpException(403, 'Вам запрещено редактировть запись');
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MedicalRecords model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $patient_id = $model->patient_id;
        $model->delete();
        return $this->redirect(['index',
            'patient_id' => $patient_id,]);
    }

    /**
     * Finds the MedicalRecords model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MedicalRecords the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MedicalRecords::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetObjectivelyForm()
    {
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (Yii::$app->request->isAjax) {
                $id = Yii::$app->request->post('id');
                $objectively = Objectively::findOne($id);
                $html = $objectively->renderForm();
                $script = $objectively->renderScript();
                $formName=Objectively::getFormName($objectively->type);

                return [
                    "html" => $html,
                    "script" => $script,
                    "form_name"=>$formName,

                ];
            }
            return [
                "data" => "Error",
                "error" => "Error"
            ];
        }
    }

    public function actionPrint($id)
    {
        $model = $this->findModel($id);
        Yii::$app->userInterface->params['patient_id'] = $model->patient_id;
        $this->layout = '@frontend/views/layouts/print';
        return $this->render('print', [
            'model' => $model,
        ]);
    }
    public function actionPrintAll($patient_id)
    {
        $this->layout = '@frontend/views/layouts/print';
        $searchModel = new MedicalRecordsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $patient_id);
        $medicalRecords=MedicalRecords::GetMedicalRecordsForPatient($patient_id);
        return $this->render('print_all', [
            'medicalRecords' => $medicalRecords,
        ]);
    }

}
