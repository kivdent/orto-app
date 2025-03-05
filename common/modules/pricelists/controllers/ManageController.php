<?php

namespace common\modules\pricelists\controllers;


use common\modules\pricelists\models\PricelistItemCompliances;
use common\modules\pricelists\models\PricelistItems;
use common\modules\pricelists\models\Prices;
use common\modules\userInterface\models\UserInterface;
use Exception;
use Yii;
use common\modules\pricelists\models\Pricelist;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * ManageController implements the CRUD actions for Pricelist model.
 */
class ManageController extends Controller
{
    public $priceListId = 'none';

    public function beforeAction($action)
    {


        if (!parent::beforeAction($action)) {
            return false;
        }

        if (($id = Yii::$app->request->get('priceListId')) != null) {
            $this->priceListId = Yii::$app->request->get('priceListId');
        }


        return true;
    }

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


    public function actionXlsSave($coefficient = false)
    {
        return $this->redirect('/' . Pricelist::getXlsxPriceList($coefficient));
    }

    /**
     * Lists all Pricelist models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Pricelist::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'priceListId' => $this->priceListId
        ]);
    }

    /**
     * Displays a single Pricelist model.
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
     * Creates a new Pricelist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pricelist();
        $model->active = $model::STATUS_ACTIVE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', ['priceListId' => $model->id]]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Pricelist model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'priceListId' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Pricelist model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->active = !($model->active);
        $model->save(false);
        return $this->redirect(['index', 'priceListId' => $model->id]);
    }

    /**
     * Finds the Pricelist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pricelist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pricelist::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionBatchEditing()
    {
        return $this->render('batch_editing', [
            'priceListId' => $this->priceListId
        ]);
    }

    public function actionUploadDraft()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $file = UploadedFile::getInstancesByName('upload-draft');
            $newPriceArray = Pricelist::getBatchEditingDataFromXls($file);
        }
        return $newPriceArray;
    }

    public function actionSaveDraft()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $newPricesArray = [];
            foreach (Yii::$app->request->post('newPricesArray') as $value) {
//                $newPricesArray[$value['id']]['price'] = $value['price'];
//                $newPricesArray[$value['id']]['coefficient'] = $value['coefficient'];
//                $newPricesArray[$value['id']]['active'] = $value['active'];
                try {
                    $newPricesArray[$value['id']]['price'] = $value['price'];
                    $newPricesArray[$value['id']]['coefficient'] = $value['coefficient'];
                    $newPricesArray[$value['id']]['active'] = $value['active'];
                }
                catch (Exception $e) {
                    echo 'Caught exception: ', $e->getMessage(), "\n";
                    echo phpinfo();
                    UserInterface::getVar($newPricesArray, false);
                    UserInterface::getVar($value);
                }

            }
        }

        return ['url' => '/' . Pricelist::getBatchEditingXls($newPricesArray)];
    }

    public function actionBatchEditingSave()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $transaction = Prices::getDb()->beginTransaction();
            try {
                foreach (Yii::$app->request->post('newPricesArray') as $value) {

                    $modelPricelistItems = PricelistItems::findOne($value['id']);
                    $modelPrices = Prices::findOne($modelPricelistItems->priceForItem->id);
                    if ($modelPrices->price !== $value['price'] or $modelPrices->coefficient !== $value['coefficient']) {

                        $newModelPrices = new Prices();

                        $newModelPrices->price = $value['price'];
                        $newModelPrices->coefficient = $value['coefficient'];
                        $newModelPrices->active = 1;
                        $newModelPrices->pricelist_items_id = $modelPricelistItems->id;


                        $modelPrices->active = 0;
                        $modelPricelistItems->active = $value['active'];
                        $modelPrices->save(false);
                        $newModelPrices->save(false);
                        $modelPricelistItems->save(false);
                    }
                }
                $transaction->commit();
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
        return 'success';
    }

    public function actionSaveToYandexDisk()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        Pricelist::saveToYandexDisk();
        return 'success';
    }

    public function actionComplianceTechnicalOrder()
    {
        return $this->render('compliance-technical-order');
    }


    public function actionCsvSave()
    {
        return $this->redirect('/' . Pricelist::getXml());
//        return $this->redirect('/' . Pricelist::getCsv());

    }

    public function actionSetCompliance($pricelistItemId)
    {
        $pricelistItem = PricelistItems::findOne($pricelistItemId);
        return $this->render('set-compliance', [
            'pricelistItem' => $pricelistItem,
        ]);
    }

    public function actionSaveCompliance()
    {
        $complianceItemId = Yii::$app->request->get('complianceItemId');
        $pricelistItemId = Yii::$app->request->get('pricelistItemId');
        $priceListItemCompliance = new PricelistItemCompliances;
        $priceListItemCompliance->pricelist_item_id = $pricelistItemId;
        $priceListItemCompliance->compliance_item_id = $complianceItemId;
        $priceListItemCompliance->save(false);
        Yii::$app->session->setFlash('success', 'Соответствие сохранено');
        return $this->redirect('/pricelists/manage/compliance-technical-order');
    }

    public function actionUpdateCompliance()
    {
        $complianceItemId = Yii::$app->request->get('complianceItemId');
        $pricelistItemId = Yii::$app->request->get('pricelistItemId');
        $priceListItem = PricelistItems::findOne($pricelistItemId);
        $priceListItem->pricelistItemCompliances->compliance_item_id = $complianceItemId;
        $priceListItem->pricelistItemCompliances->save(false);
        Yii::$app->session->setFlash('success', 'Соответствие обновлено');
        return $this->redirect('/pricelists/manage/compliance-technical-order');
    }

    public function actionDeleteCompliance()
    {
        PricelistItemCompliances::findOne(Yii::$app->request->get('id'))->delete();
        return $this->redirect('/pricelists/manage/compliance-technical-order');

    }
}
