<?php

namespace common\modules\invoice\controllers;

use common\modules\invoice\models\Invoice;

class TechnicalOrderController extends \yii\web\Controller
{
    public function actionCreate($patient_id,$invoice_type = Invoice::TYPE_TECHNICAL_ORDER, $appointment_id = 0, $employee_choice=false)
    {

        return $this->render('create', [
            'patient_id' => $patient_id,
            'appointment_id' => $appointment_id,
            'invoice_type' => $invoice_type,
            'employee_choice' => $employee_choice,
        ]);

    }

    public function actionGetAjaxTable()
    {
        return $this->render('get-ajax-table');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPrint()
    {
        return $this->render('print');
    }

    public function actionSaveAjax()
    {
        return $this->render('save-ajax');
    }

}
