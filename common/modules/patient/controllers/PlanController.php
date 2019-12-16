<?php

namespace common\modules\patient\controllers;

use common\modules\patient\models\forms\PlanItemForm;
use common\modules\patient\models\forms\TreatmentPlanForm;
use Yii;
use common\modules\patient\models\TreatmentPlan;
use common\modules\patient\models\SearchTreatmentPlan;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//use yii\base\Model;
use common\models\DynamicFormModel as Model;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$patient_id);

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
        return $this->render('view', [
            'model' => $this->findModel($id),
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
        $model->author=Yii::$app->user->identity->employe_id;
        $model->patient=Yii::$app->request->get('patient_id');
        $modelsPlanItem=[new PlanItemForm()];

        if ($model->load(Yii::$app->request->post())) {

            $modelsPlanItem = Model::createMultiple(PlanItemForm::classname());
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
                            if (! ($flag = $modelItem->save(false))) {
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

        return $this->render('create', [
            'model' => $model,
            'modelsPlanItem' => (empty($modelsPlanItem)) ? [new PlanItemForm] : $modelsPlanItem
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
        $modelsPlanItem=$model->planItems;


        if ($model->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsPlanItem, 'id', 'id');
            $modelsPlanItem = Model::createMultiple(PlanItemForm::classname(), $modelsPlanItem);
            Model::loadMultiple($modelsPlanItem, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsPlanItem, 'id', 'id')));

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
                        if (! empty($deletedIDs)) {
                            PlanItemForm::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsPlanItem as $modelItem) {
                            $modelItem->plan_id = $model->id;
                            if (! ($flag = $modelItem->save(false))) {
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
//        echo "<pre>";
//        print_r($modelsPlanItem);
//        echo "</pre>";
//        die();
        return $this->render('update', [
            'model' => $model,
            'modelsPlanItem' => (empty($modelsPlanItem)) ? [new PlanItemForm] : $modelsPlanItem
        ]);

    }

    /**
     * Deletes an existing TreatmentPlan model.
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
}
