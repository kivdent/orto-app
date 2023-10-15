<?php

namespace common\modules\patient\controllers;


use common\modules\patient\models\forms\TreatmentPlanForm;
use common\modules\patient\models\Operation;
use common\modules\patient\models\Region;
use Yii;
use common\modules\patient\models\TreatmentPlan;
use common\modules\patient\models\SearchTreatmentPlan;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//use yii\base\Model;
use common\models\DynamicFormModel as Model;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\modules\patient\models\PlanItem;

/**
 * PlanController implements the CRUD actions for TreatmentPlan model.
 */
class PlanController extends Controller
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
                        'actions' => ['index', 'view', 'update', 'create','prices','print','print-budget'],
                        'roles' => ['admin', 'therapist', 'orthopedist', 'surgeon', 'orthodontist', 'recorder', 'senior_nurse',],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['admin',],
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
     * Lists all TreatmentPlan models.
     * @return mixed
     */
    public function actionIndex($patient_id)
    {
        $searchModel = new SearchTreatmentPlan();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $patient_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TreatmentPlan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        Yii::$app->userInterface->params['patient_id'] = $model->patient;

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionPrint($id)
    {
        $model = $this->findModel($id);
        Yii::$app->userInterface->params['patient_id'] = $model->patient;
        $this->layout = '@frontend/views/layouts/print';
        return $this->render('print', [
            'model' => $model,
        ]);
    } public function actionPrintBudget($id)
    {
        $model = $this->findModel($id);
        Yii::$app->userInterface->params['patient_id'] = $model->patient;
        $this->layout = '@frontend/views/layouts/print';
        return $this->render('print-budget', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new TreatmentPlan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TreatmentPlanForm();
        $model->author = Yii::$app->user->identity->employe_id;
        $model->patient = Yii::$app->request->get('patient_id');
        $model->deleted = 0;
        $model->status=TreatmentPlan::PLAN_STATUS_CREATED;
        $modelsPlanItem = [new PlanItem([
            'operation_id'=>Operation::FROM_COMMENT,
            'region_id'=>Region::ID_ALL,
        ])
        ];

        if ($model->load(Yii::$app->request->post())) {

            $modelsPlanItem = Model::createMultiple(PlanItem::classname());
            Model::loadMultiple($modelsPlanItem, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsPlanItem),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsPlanItem) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsPlanItem as $modelItem) {
                            $modelItem->plan_id = $model->id;
                            if (!($flag = $modelItem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        Yii::$app->userInterface->params['patient_id'] = $model->patient;
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelsPlanItem' => (empty($modelsPlanItem)) ? [new PlanItem] : $modelsPlanItem
        ]);

    }

    /**
     * Updates an existing TreatmentPlan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);
        $modelsPlanItem = $model->planItems;
        Yii::$app->userInterface->params['patient_id'] = $model->patient;

        if ($model->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsPlanItem, 'id', 'id');

            $modelsPlanItem = Model::createMultiple(PlanItem::classname(), $modelsPlanItem);
            Model::loadMultiple($modelsPlanItem, Yii::$app->request->post());

            $deletedIDs = array_diff($oldIDs, (ArrayHelper::map($modelsPlanItem, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsPlanItem),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsPlanItem) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (!empty($deletedIDs)) {
                            PlanItem::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsPlanItem as $modelItem) {
                            $modelItem->plan_id = $model->id;
                            if (!($flag = $modelItem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelsPlanItem' => (empty($modelsPlanItem)) ? [new PlanItem] : $modelsPlanItem
        ]);

    }

    /**
     * Deletes an existing TreatmentPlan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $patient_id)
    {
        $this->findModel($id)->setDeleted();

        return $this->redirect(['index', 'patient_id' => $patient_id]);
    }

    /**
     * Finds the TreatmentPlan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TreatmentPlan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TreatmentPlanForm::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPrices()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');
            $operation = Operation::findOne($id);
            if (isset($operation->price_from) ? true : false) {
                return [
                    "price_from" => $operation->price_from,
                    "price_to" => $operation->price_to,
                    "actualPrice"=>$operation->actualPrice,
                    "error" => null
                ];
            } else {
                return [
                    "empty" => 'true',
                    "error" => null
                ];
            }


        }
        return [
            "data" => "Error",
            "error" => "Error"
        ];
    }
}
