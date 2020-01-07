<?php

namespace common\modules\catalogs\controllers;

use Yii;
use common\modules\catalogs\models\Objectively;
use common\modules\catalogs\models\ObjectivelyItems;
use common\modules\catalogs\models\ObjectivelySubItems;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\DynamicFormModel as Model;
use yii\helpers\ArrayHelper;
use yii\base\Exception;

/*
    Person ->   Objectively
    House->     ObjectivelyItems
    Room->      ObjectivelySubItems
*/

/**
 * ObjectivelyController implements the CRUD actions for Objectively model.
 */
class ObjectivelyController extends Controller
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
                        'actions' => ['index', 'view', 'update', 'create'],
                        'roles' => ['admin',],
                    ],

                ],
            ],
        ];
    }

    /**
     * Lists all Objectively models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Objectively::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Objectively model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $objectivelyItems = $model->objectivelyItems;
        return $this->render('view', [
            'model' => $model,
            'objectivelyItems' => $objectivelyItems,
        ]);
    }

    /**
     * Creates a new Objectively model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $modelObjectively = new Objectively;
        $modelsObjectivelyItems = [new ObjectivelyItems];
        $modelsObjectivelySubItems = [[new ObjectivelySubItems]];

        if ($modelObjectively->load(Yii::$app->request->post())) {

            $modelsObjectivelyItems = Model::createMultiple(ObjectivelyItems::classname());
            Model::loadMultiple($modelsObjectivelyItems, Yii::$app->request->post());

            // validate objectively and objectively_Itemss models
            $valid = $modelObjectively->validate();
            $valid = Model::validateMultiple($modelsObjectivelyItems) && $valid;

            if (isset($_POST['ObjectivelySubItems'][0][0])) {
                foreach ($_POST['ObjectivelySubItems'] as $indexObjectivelyItems => $rooms) {
                    foreach ($rooms as $indexObjectivelySubItems => $room) {
                        $data['ObjectivelySubItems'] = $room;
                        $modelObjectivelySubItems = new ObjectivelySubItems;
                        $modelObjectivelySubItems->load($data);
                        $modelsObjectivelySubItems[$indexObjectivelyItems][$indexObjectivelySubItems] = $modelObjectivelySubItems;
                        $valid = $modelObjectivelySubItems->validate();
                    }
                }
            }

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelObjectively->save(false)) {
                        foreach ($modelsObjectivelyItems as $indexObjectivelyItems => $modelObjectivelyItems) {

                            if ($flag === false) {
                                break;
                            }

                            $modelObjectivelyItems->objectively_id = $modelObjectively->id;

                            if (!($flag = $modelObjectivelyItems->save(false))) {
                                break;
                            }

                            if (isset($modelsObjectivelySubItems[$indexObjectivelyItems]) && is_array($modelsObjectivelySubItems[$indexObjectivelyItems])) {
                                foreach ($modelsObjectivelySubItems[$indexObjectivelyItems] as $indexObjectivelySubItems => $modelObjectivelySubItems) {
                                    $modelObjectivelySubItems->objectively_Items_id = $modelObjectivelyItems->id;
                                    if (!($flag = $modelObjectivelySubItems->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelObjectively->id]);
                    } else {


                        $transaction->rollBack();

                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->addFlash('error', $e);
                }
            }
        }

        return $this->render('create', [
            'modelObjectively' => $modelObjectively,
            'modelsObjectivelyItems' => (empty($modelsObjectivelyItems)) ? [new ObjectivelyItems] : $modelsObjectivelyItems,
            'modelsObjectivelySubItems' => (empty($modelsObjectivelySubItems)) ? [[new ObjectivelySubItems]] : $modelsObjectivelySubItems,
        ]);


    }

    /**
     * Updates an existing Objectively model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $modelObjectively = $this->findModel($id);
        $modelsObjectivelyItems = $modelObjectively->objectivelyItems;
        $modelsObjectivelySubItems = [];
        $oldObjectivelySubItems = [];

        if (!empty($modelsObjectivelyItems)) {
            foreach ($modelsObjectivelyItems as $indexObjectivelyItems => $modelObjectivelyItems) {
                $subItems = $modelObjectivelyItems->subItems;
                $modelsObjectivelySubItems[$indexObjectivelyItems] = $subItems;
                $oldObjectivelySubItems = ArrayHelper::merge(ArrayHelper::index($subItems, 'id'), $oldObjectivelySubItems);
            }
        }

        if ($modelObjectively->load(Yii::$app->request->post())) {

            // reset
            $modelsObjectivelySubItems = [];

            $oldObjectivelyItemsIDs = ArrayHelper::map($modelsObjectivelyItems, 'id', 'id');
            $modelsObjectivelyItems = Model::createMultiple(ObjectivelyItems::classname(), $modelsObjectivelyItems);
            Model::loadMultiple($modelsObjectivelyItems, Yii::$app->request->post());
            $deletedObjectivelyItemsIDs = array_diff($oldObjectivelyItemsIDs, array_filter(ArrayHelper::map($modelsObjectivelyItems, 'id', 'id')));

            // validate objectively and objectivelyItems models
            $valid = $modelObjectively->validate();
            $valid = Model::validateMultiple($modelsObjectivelyItems) && $valid;

            $subItemsIDs = [];
            if (isset($_POST['ObjectivelySubItems'][0][0])) {
                foreach ($_POST['ObjectivelySubItems'] as $indexObjectivelyItems => $subItems) {
                    $subItemsIDs = ArrayHelper::merge($subItemsIDs, array_filter(ArrayHelper::getColumn($subItems, 'id')));
                    foreach ($subItems as $indexObjectivelySubItems => $subItem) {
                        $data['ObjectivelySubItems'] = $subItem;
                        $modelObjectivelySubItems = (isset($subItem['id']) && isset($oldObjectivelySubItems[$subItem['id']])) ? $oldObjectivelySubItems[$subItem['id']] : new ObjectivelySubItems;
                        $modelObjectivelySubItems->load($data);
                        $modelsObjectivelySubItems[$indexObjectivelyItems][$indexObjectivelySubItems] = $modelObjectivelySubItems;
                        $valid = $modelObjectivelySubItems->validate();
                    }
                }
            }

            $oldObjectivelySubItemsIDs = ArrayHelper::getColumn($oldObjectivelySubItems, 'id');
            $deletedObjectivelySubItemsIDs = array_diff($oldObjectivelySubItemsIDs, $subItemsIDs);

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelObjectively->save(false)) {

                        if (!empty($deletedObjectivelySubItemsIDs)) {
                            ObjectivelySubItems::deleteAll(['id' => $deletedObjectivelySubItemsIDs]);
                        }

                        if (!empty($deletedObjectivelyItemsIDs)) {
                            ObjectivelyItems::deleteAll(['id' => $deletedObjectivelyItemsIDs]);
                        }

                        foreach ($modelsObjectivelyItems as $indexObjectivelyItems => $modelObjectivelyItems) {

                            if ($flag === false) {
                                break;
                            }

                            $modelObjectivelyItems->objectively_id = $modelObjectively->id;

                            if (!($flag = $modelObjectivelyItems->save(false))) {
                                break;
                            }

                            if (isset($modelsObjectivelySubItems[$indexObjectivelyItems]) && is_array($modelsObjectivelySubItems[$indexObjectivelyItems])) {
                                foreach ($modelsObjectivelySubItems[$indexObjectivelyItems] as $indexObjectivelySubItems => $modelObjectivelySubItems) {
                                    $modelObjectivelySubItems->objectively_Items_id = $modelObjectivelyItems->id;
                                    if (!($flag = $modelObjectivelySubItems->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelObjectively->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->addFlash('error', $e);
                }
            }
        }

        return $this->render('update', [
            'modelObjectively' => $modelObjectively,
            'modelsObjectivelyItems' => (empty($modelsObjectivelyItems)) ? [new ObjectivelyItems] : $modelsObjectivelyItems,
            'modelsObjectivelySubItems' => (empty($modelsObjectivelySubItems)) ? [[new ObjectivelySubItems]] : $modelsObjectivelySubItems
        ]);
    }

    /**
     * Deletes an existing Objectively model.
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
     * Finds the Objectively model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Objectively the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Objectively::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
