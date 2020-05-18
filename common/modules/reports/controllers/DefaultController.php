<?php

namespace common\modules\reports\controllers;

use common\modules\employee\models\Employee;
use common\modules\invoice\models\Invoice;
use common\modules\invoice\models\InvoiceSearch;
use common\modules\reports\models\FinancialPeriods;
use common\modules\reports\models\InvoiceReport;
use common\modules\reports\models\PaymentReport;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `reports` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $employee=Employee::findOne(Yii::$app->user->identity->employe_id);
        $financialPeriod=FinancialPeriods::getPeriodForCurrentDate();
        $table=PaymentReport::getAllForPeriod($employee,$financialPeriod);

        return $this->render('index',['table'=>$table]);
    }
    public function actionInvoices()
    {
        $employee=Employee::findOne(Yii::$app->user->identity->employe_id);
        $financialPeriod=FinancialPeriods::getPeriodForCurrentDate();
        $table=InvoiceReport::getAllPaidForPeriod($employee,$financialPeriod);

        return $this->render('index',['table'=>$table]);
    }
    public function actionEmployeeDebt(){
        $searchModel = new InvoiceSearch(['searchType' => InvoiceSearch::SEARCH_TYPE_EMPLOYEE_DEBT]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('employee-debt', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);

    }
}
