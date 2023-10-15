<?php

namespace common\modules\catalogs\controllers;

use common\modules\patient\models\OperationPricelistItemsCompliance;
use common\modules\pricelists\models\Prices;
use common\modules\userInterface\models\UserInterface;
use Yii;
use common\modules\patient\models\Operation;
use common\modules\catalogs\models\OperationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * OperationController implements the CRUD actions for Operation model.
 */
class OperationController extends Controller
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
     * Lists all Operation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OperationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Operation model.
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
     * Creates a new Operation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Operation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Operation model.
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
     * Deletes an existing Operation model.
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

    public function actionSetCompliance($operation_id)
    {
        $operation = $this->findModel($operation_id);

        return false;
    }

    public function actionClearCompliance($operation_id)
    {
        $operation = $this->findModel($operation_id);
        foreach ($operation->pricelistItems as $pricelistItem) {
            $pricelistItem->delete();
        }
        Yii::$app->session->setFlash('success', 'Соответсвия удалены');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Operation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Operation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Operation::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSaveAjax()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $operation_compliances = [];

            if (Operation::findOne(Yii::$app->request->post('operation_id'))->pricelistItems !== null) {
                foreach (Operation::findOne(Yii::$app->request->post('operation_id'))->operationCompliance as $operationCompliance) {

                }
            }
            foreach (Yii::$app->request->post('items') as $item) {
                $operation_compliance = new OperationPricelistItemsCompliance();
                $operation_compliance->pricelist_item_id = Prices::findOne($item['id'])->pricelist_items_id;
                $operation_compliance->quantity = $item['quantity'];
                $operation_compliance->operation_id = Yii::$app->request->post('operation_id');
                $operation_compliances[] = $operation_compliance;
            }
            $transaction = OperationPricelistItemsCompliance::getDb()->beginTransaction();
            try {
                $operation = Operation::findOne(Yii::$app->request->post('operation_id'));

                if ($operation->operationCompliance !== null) {
                    foreach ($operation->operationCompliance as $oldOperationCompliance) {
                        $oldOperationCompliance->delete();
                    }
                }

                foreach ($operation_compliances as $operation_compliance) {
                    $operation_compliance->save(false);
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
}