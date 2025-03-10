<?php

namespace common\modules\patient\controllers;

use common\modules\patient\models\Patient;
use common\modules\userInterface\models\UserInterface;
use Yii;
use common\modules\patient\models\forms\PatientForm;
use common\modules\patient\models\PatientSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ManageController implements the CRUD actions for Patient model.
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
                        'actions' => ['index', 'view', 'update', 'create'],
                        'roles' => ['admin', 'therapist', 'orthopedist', 'surgeon', 'orthodontist', 'recorder', 'senior_nurse', 'senior_recorder', 'accountant','radiologist'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view', ],
                        'roles' => [UserInterface::ROLE_TECHNICIAN],
                    ],

                ],
            ],
        ];
    }

    /**
     * Lists all Patient models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PatientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Patient model.
     * @param double $patient_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($patient_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($patient_id),
        ]);
    }

    /**
     * Creates a new Patient model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PatientForm();


        if ($model->load(Yii::$app->request->post()) && $model->addressForm->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'patient_id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Patient model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param double $patient_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($patient_id)
    {
        /* @var PatientForm $model */
        $model = $this->findModel($patient_id);
        $oldStatus = $model->status;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->status != Patient::STATUS_ARCHIVE_IN_ARCHIVE) {
                if ($model->addressForm->load(Yii::$app->request->post()) && $model->save()) {
                    Yii::$app->session->setFlash('success', 'Карта сохранена');
                    $model->dr = Yii::$app->formatter->asDate($model->dr, 'php:d.m.Y');
                }
            } else {
                Yii::$app->session->setFlash('danger', 'Статус \"В архиве\" установить не нельзя');
                $model->status = $oldStatus;
            }

        }
        $model->addressForm->city = $model->addressForm->city == '' ? 'Новокузнецк' : $model->addressForm->city;
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Patient model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param double $patient_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public
    function actionDelete($patient_id)
    {
        $this->findModel($patient_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Patient model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param double $patient_id
     * @return Patient the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected
    function findModel($patient_id)
    {
        if (($model = PatientForm::findOne($patient_id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Страница не найдена.');
    }
}
