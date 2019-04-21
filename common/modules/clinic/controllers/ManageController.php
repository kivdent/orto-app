<?php

namespace common\modules\clinic\controllers;

use Yii;
use common\modules\clinic\models\CreateForm;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ManageController implements the CRUD actions for Clinics model.
 */
class ManageController extends Controller {

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
     * Lists all Clinics models.
     * @return mixed
     */
    public function actionIndex() {
        $entityClass = Yii::$app->controller->module->getEntitysClass('clinic');
        $entities = $entityClass::getAll();
       
        if ($entities==NULL) {
            return $this->redirect(['create']);
        } else {
            
            if (count($entities) === 1) {
                return $this->redirect(['update', 'clinic_id' => $entities[0]->getId()]);
            } else {
                $dataProvider = new ArrayDataProvider(
                        [
                            'allModels' => $entities,
                            ]
                        );
                return $this->render('index', ['dataProvider' => $dataProvider]);
            }
        }
    }

    /**
     * Displays a single Clinics model.
     * @param integer $clinic_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($clinic_id) {
        return $this->render('view', [
                    'model' => $this->findModel($clinic_id),
        ]);
    }

    /**
     * Creates a new Clinics model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new CreateForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
              Yii::$app->session->setFlash('success','Клиника создана');
            return $this->redirect(['update', 'clinic_id' => $model->clinic->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Clinics model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $clinic_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($clinic_id) {
        $model = $this->findModel($clinic_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
              Yii::$app->session->setFlash('success','Данные о клинике обновлены');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Clinics model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $clinic_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($clinic_id) {
        $this->findModel($clinic_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Clinics model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $clinic_id
     * @return Clinics the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($clinic_id) {
        $model = CreateForm::getById($clinic_id);
        if (isset($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует');
        }
    }

}
