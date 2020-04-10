<?php

namespace common\modules\pricelists\controllers;

use common\modules\pricelists\models\Prices;
use Yii;
use common\modules\pricelists\models\PricelistItems;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PriceController implements the CRUD actions for PricelistItems model.
 */
class PriceController extends Controller
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
     * Lists all PricelistItems models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PricelistItems::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PricelistItems model.
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
     * Creates a new PricelistItems model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateCategory($pricelist_id, $category, $superior_category_id)
    {
        $model = new PricelistItems();
        $model->pricelist_id = $pricelist_id;
        $model->category = $category;
        $model->superior_category_id = $superior_category_id;
        $model->active = 1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/pricelists/manage','priceListId'=>$model->pricelist_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreatePrice($pricelist_id, $category, $superior_category_id)
    {
        $modelPricelistItems = new PricelistItems();
        $modelPricelistItems->pricelist_id = $pricelist_id;
        $modelPricelistItems->category = $category;
        $modelPricelistItems->superior_category_id = $superior_category_id;
        $modelPricelistItems->active = 1;
        $modelPrices = new Prices();
        $modelPrices->active = 1;


        if ($modelPricelistItems->load(Yii::$app->request->post()) && $modelPrices->load(Yii::$app->request->post())) {
            $isValidate = $modelPricelistItems->validate();
            $isValidate = $isValidate && $modelPrices->validate();
            if ($isValidate) {
                $transaction = Prices::getDb()->beginTransaction();
                try {
                    $modelPricelistItems->save(false);
                    $modelPrices->pricelist_items_id = $modelPricelistItems->id;
                    $modelPrices->save(false);
                    $transaction->commit();
                } catch (\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
                return $this->redirect(['/pricelists/manage','priceListId'=>$modelPricelistItems->pricelist_id]);
            }


        }

        return $this->render('create_price', [
            'modelPricelistItems' => $modelPricelistItems,
            'modelPrices' => $modelPrices
        ]);
    }

    /**
     * Updates an existing PricelistItems model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateCategory($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/pricelists/manage', 'priceListId'=>$model->pricelist_id, 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdatePrice($id)
    {
        $modelPricelistItems = PricelistItems::findOne($id);
        $modelPrices = $modelPricelistItems->priceForItem;
        if ($modelPricelistItems->load(Yii::$app->request->post()) && $modelPrices->load(Yii::$app->request->post())) {
            $isValidate = $modelPricelistItems->validate();
            $isValidate = $isValidate && $modelPrices->validate();
            if ($isValidate) {
                $transaction = Prices::getDb()->beginTransaction();
                try {
                    $modelPricelistItems->save(false);
                    if ($modelPrices->isChanged()){
                        $newModelPrices=new Prices();
                        $newModelPrices->load(Yii::$app->request->post());
                        $newModelPrices->active=1;
                        $newModelPrices->pricelist_items_id=$modelPricelistItems->id;
                        $modelPrices=Prices::findOne($modelPrices->id);
                        $modelPrices->active=0;
                        $modelPrices->save(false);
                        $newModelPrices->save(false);
                    }
                    $transaction->commit();
                } catch (\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
                return $this->redirect(['/pricelists/manage', 'priceListId'=>$modelPricelistItems->pricelist_id]);
            }


        }
        return $this->render('update_price', [
            'modelPricelistItems' => $modelPricelistItems,
            'modelPrices' => $modelPrices,
        ]);
    }

    /**
     * Deletes an existing PricelistItems model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        $model->active=!$model->active;
        $model->save(false);
        return $this->redirect(['/pricelists/manage','priceListId'=>$model->pricelist_id]);
    }

    /**
     * Finds the PricelistItems model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PricelistItems the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PricelistItems::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
