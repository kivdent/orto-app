<?php

namespace common\modules\invoice\controllers;

use common\modules\invoice\models\Invoice;
use common\modules\invoice\models\InvoiceItems;
use common\modules\invoice\models\TechnicalOrder;
use common\modules\userInterface\models\UserInterface;
use Yii;
use yii\web\Response;

class TechnicalOrderController extends \yii\web\Controller
{
    public function actionCreate($invoice_id, $employee_choice = false)
    {
        $invoice = Invoice::findOne($invoice_id);

        return $this->render('create', [
            'patient_id' => $invoice->patient_id,
            'appointment_id' => $invoice->appointment_id,
            'invoice_type' => $invoice->type,
            'employee_choice' => $employee_choice,
//            'invoice_id'=>$invoice->id,
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
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax) {
            $technicalOrder = new TechnicalOrder(
                [
                    'invoice_id' => Yii::$app->request->post('invoice_id'),
                    'employee_id' => Yii::$app->request->post('employee_id'),
                    'delivery_date' => Yii::$app->request->post('delivery_date'),
                    'completed' => false
                ]
            );
            $invoice_items = [];
            $invoice = new Invoice([
                'patient_id' => $technicalOrder->invoice->patient_id,
                'doctor_id' => $technicalOrder->employee_id,
                'type' =>  Invoice::TYPE_TECHNICAL_ORDER,
                'amount' => 0,
                'appointment_id' => (Yii::$app->request->post('appointment_id') !== null)? Yii::$app->request->post('appointment_id'):0,

            ]);

            foreach (Yii::$app->request->post('items') as $item) {
                $invoice_item = new InvoiceItems();
                $invoice_item->prices_id = $item['id'];
                $invoice_item->quantity = $item['quantity'];
                $invoice->amount += $invoice_item->summary;
                $invoice_items[] = $invoice_item;
            }
            $invoice->amount_payable = $invoice->amount;

            $transaction = InvoiceItems::getDb()->beginTransaction();
            try {
                $invoice->save(false);
                $technicalOrder->technical_order_invoice_id = $invoice->id;
                $technicalOrder->save(false);
                foreach ($invoice_items as $invoice_item) {
                    $invoice_item->invoice_id = $invoice->id;
                    $invoice_item->save(false);
                }
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Заказ-наряд успешно сохранён.');
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
            return 'success';
        }
        return 'error';
    }

}