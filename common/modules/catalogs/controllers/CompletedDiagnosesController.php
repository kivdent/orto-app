<?php

namespace common\modules\catalogs\controllers;

use common\models\CompletedDiagnosesForManipulations;
use common\modules\pricelists\models\Prices;
use common\modules\userInterface\models\UserInterface;
use Yii;
use common\modules\catalogs\models\CompletedDiagnoses;
use common\modules\catalogs\models\CompletedDiagnosesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * CompletedDiagnosesController implements the CRUD actions for CompletedDiagnoses model.
 */
class CompletedDiagnosesController extends Controller
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
     * Lists all CompletedDiagnoses models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompletedDiagnosesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CompletedDiagnoses model.
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
     * Creates a new CompletedDiagnoses model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CompletedDiagnoses();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CompletedDiagnoses model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CompletedDiagnoses model.
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
     * Finds the CompletedDiagnoses model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CompletedDiagnoses the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CompletedDiagnoses::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSaveAjax()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax) {
            $compliances = [];

            foreach (Yii::$app->request->post('items') as $item) {
                $completed_diagnoses_for_manipulations = new CompletedDiagnosesForManipulations();
                $completed_diagnoses_for_manipulations->pricelist_items_id = Prices::findOne($item['id'])->pricelist_items_id;
                $completed_diagnoses_for_manipulations->completed_diagnoses_id = Yii::$app->request->post('id');
                $compliances[] = $completed_diagnoses_for_manipulations;
            }

            $transaction = CompletedDiagnosesForManipulations::getDb()->beginTransaction();

            try {

                $completedDiagnoses = CompletedDiagnoses::findOne(Yii::$app->request->post('id'));

                if ($completedDiagnoses->completedDiagnosesForManipulations !== null) {
                    foreach ($completedDiagnoses->completedDiagnosesForManipulations as $oldOperationCompliance) {
                        $oldOperationCompliance->delete();
                    }
                }
                foreach ($compliances as $completed_diagnoses_for_manipulations) {
                    $completed_diagnoses_for_manipulations->save(false);
                }
                $transaction->commit();
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
            return 'success';
        }

        return 'error';
    }

    public function actionGetPricesItems()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax) {
            $completedDiagnoses = CompletedDiagnoses::findOne(Yii::$app->request->post('id'));
            $invoiceItems = [];
            foreach ($completedDiagnoses->completedDiagnosesForManipulations as $completedDiagnosesForManipulation) {
                $pricelistItems=$completedDiagnosesForManipulation->pricelistItems;
                $item['title'] = $pricelistItems->title;
                $item['id'] = $pricelistItems->priceForItem->id;
                $item['price'] = $pricelistItems->priceForItem->price;
                $item['quantity'] = 1;
                $invoiceItems[] = $item;
            }

            return $invoiceItems;
        }
    }
}
