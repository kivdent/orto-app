<?php

namespace common\modules\patient\controllers;

use common\modules\invoice\models\InvoiceSearch;
use Yii;

class InvoicesController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $this->layout = '@frontend/views/layouts/light';
        return true; // or false to not run the action
    }
    public function actionIndex($patient_id)
    {

        $searchModel = new InvoiceSearch(['searchType' => InvoiceSearch::SEARCH_TYPE_DOCTOR_INVOICES,'patient_card_id' =>$patient_id ]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    public function actionView()
    {
        return $this->render('view');
    }
    public function actionTechnicalOrder($patient_id)
    {
        $searchModel = new InvoiceSearch(['searchType' => InvoiceSearch::SEARCH_TYPE_TECHNICAL_ORDER,'patient_card_id' =>$patient_id ]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('technical_order', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }
}
