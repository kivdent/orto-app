<?php

namespace common\modules\pricelists\controllers;


use Yii;
use common\modules\pricelists\models\Pricelist;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
}
