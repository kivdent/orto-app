<?php

namespace common\modules\reports\controllers;

use common\modules\cash\models\Cashbox;
use common\modules\clinic\models\FinancialDivisions;
use common\modules\reports\models\FinancialReports;
use Yii;

class FinancialController extends \yii\web\Controller
{
    public function actionDaily()
    {
        $cashbox = Cashbox::getCurrentCashBox();
        if ($cashbox == null or $cashbox->isClosed()) {
            return $this->redirect('/old_app/kassa.php?action=nach&step=1');
        }
        $divisions=FinancialDivisions::getDivisionList();
        $financial_report = FinancialReports::getToday();
        return $this->render('daily', [
            'cashbox' => $cashbox,
            'financial_report' => $financial_report,
            'divisions' => $divisions,
            'print'=>false,
        ]);
    }

    public function actionDailyPrint($division_id)
    {
        $cashbox = Cashbox::getCurrentCashBox();
        if ($cashbox == null or $cashbox->isClosed()) {
            return $this->redirect('/old_app/kassa.php?action=nach&step=1');
        }
        $financial_report = FinancialReports::getToday();

        $divisions=[];
        $divisions[$division_id]=FinancialDivisions::getDivisionList()[$division_id];
       // Yii::$app->controller->layout='@frontend/views/layouts/print';
       $this->layout = '@frontend/views/layouts/print';
        return $this->render('daily_print', [
            'cashbox' => $cashbox,
            'financial_report' => $financial_report,
            'divisions' => $divisions,
            'print'=>true,
        ]);
    }
}
