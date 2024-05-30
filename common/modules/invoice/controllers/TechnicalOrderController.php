<?php

namespace common\modules\invoice\controllers;

use common\modules\invoice\models\Invoice;
use common\modules\invoice\models\InvoiceItems;
use common\modules\invoice\models\InvoiceSearch;
use common\modules\invoice\models\TechnicalOrder;
use common\modules\userInterface\models\UserInterface;
use Yii;
use yii\web\Response;

class TechnicalOrderController extends \yii\web\Controller
{
    public function actionCreate($invoice_id, $employee_choice = false, $invoice_type = 'technical_order')
    {
        $invoice = Invoice::findOne($invoice_id);

        return $this->render('create', [
            'patient_id' => $invoice->patient_id,
            'appointment_id' => $invoice->appointment_id,
            'invoice_type' => $invoice_type,
            'employee_choice' => $employee_choice,
//            'invoice_id'=>$invoice->id,
        ]);
    }

    public function actionUpdate($technical_order_id, $employee_choice = false, $invoice_type = 'technical_order')
    {
        $technical_order = TechnicalOrder::findOne($technical_order_id);

        return $this->render('update', [
            'patient_id' => $technical_order->invoice->patient_id,
            'appointment_id' => $technical_order->invoice->appointment_id,
            'invoice_type' => $invoice_type,
            'employee_choice' => $employee_choice,
            'technical_order_id' => $technical_order_id,
            'invoice_id' => $technical_order->technical_order_invoice_id,
        ]);
    }

    public function actionAjaxComplete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            //  echo Yii::$app->request->post('technicalOrderId');

            foreach (TechnicalOrder::findOne(Yii::$app->request->post('technicalOrderId'))->invoice->getTechnicalOrderInvoice() as $technicalOrder) {
                $technicalOrder->changeStatus(TechnicalOrder::STATUS_COMPLETED);
//                $technicalOrder->completed = !$technicalOrder->completed;
//                if ($technicalOrder->completed and $technicalOrder->completed_date == NULL) {
//                    $technicalOrder->completed_date = date('Y-m-d');
//                }
//                if ($technicalOrder->completed) {
//                    $technicalOrder->technicalOrderInvoice->paid = $technicalOrder->technicalOrderInvoice->amount_payable;
//                } else {
//                    $technicalOrder->technicalOrderInvoice->paid = 0;
//                }
//                $technicalOrder->technicalOrderInvoice->save(false);
//                $technicalOrder->save(false);
            }
//        Yii::$app->response->format = Response::FORMAT_JSON;
//        if (Yii::$app->request->isAjax) {
//            //  echo Yii::$app->request->post('technicalOrderId');
//            $technicalOrder = TechnicalOrder::findOne(Yii::$app->request->post('technicalOrderId'));
//            $technicalOrder->completed = !$technicalOrder->completed;
//            if ($technicalOrder->completed and $technicalOrder->completed_date == NULL) {
//                $technicalOrder->completed_date = date('Y-m-d');
//            }
//            if ($technicalOrder->completed) {
//                $technicalOrder->technicalOrderInvoice->paid = $technicalOrder->technicalOrderInvoice->amount_payable;
//            } else {
//                $technicalOrder->technicalOrderInvoice->paid = 0;
//            }
//            $technicalOrder->technicalOrderInvoice->save(false);
//            $technicalOrder->save(false);
        }
        return $technicalOrder->completed;
    }
    public function actionAjaxCompleteOne()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {

            $technicalOrder=TechnicalOrder::findOne(Yii::$app->request->post('technicalOrderId'));
            $technicalOrder->changeStatus(TechnicalOrder::STATUS_COMPLETED);
//            $technicalOrder->completed = !$technicalOrder->completed;
//            if ($technicalOrder->completed and $technicalOrder->completed_date == NULL) {
//                $technicalOrder->completed_date = date('Y-m-d');
//            }
//            if ($technicalOrder->completed) {
//                $technicalOrder->technicalOrderInvoice->paid = $technicalOrder->technicalOrderInvoice->amount_payable;
//            } else {
//                $technicalOrder->technicalOrderInvoice->paid = 0;
//            }
//            $technicalOrder->technicalOrderInvoice->save(false);
//            $technicalOrder->save(false);

        }
        return $technicalOrder->completed;
    }

    public function actionGetAjaxTable()
    {
        return $this->render('get-ajax-table');
    }

    public function actionIndex($searchType= InvoiceSearch::SEARCH_TYPE_TECHNICAL_ORDER_TECHNICIAN)
    {
        if (UserInterface::getRoleNameCurrentUser()==UserInterface::ROLE_ADMIN
        || UserInterface::isUserRole(UserInterface::ROLE_ACCOUNTANT)){
            $searchType= InvoiceSearch::SEARCH_TYPE_TECHNICAL_ORDER_ALL;
        }
        if (UserInterface::isUserRole(UserInterface::ROLE_ORTHODONTIST)
        || UserInterface::isUserRole(UserInterface::ROLE_ORTHOPEDIST)){
            $searchType= InvoiceSearch::SEARCH_TYPE_TECHNICAL_ORDER_DOCTOR;
        }

        $searchModel = new InvoiceSearch(['searchType' => $searchType]);
//       UserInterface::getVar($searchModel);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [//@common/modules/patient/views/technical-order/index
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);

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
                    'delivery_date' => date('Y-m-d', strtotime(Yii::$app->request->post('delivery_date'))),
                    'completed' => false,
                    'comment'=>Yii::$app->request->post('comment'),
                ]
            );
            $invoice_items = [];
            $invoice = new Invoice([
                'patient_id' => $technicalOrder->invoice->patient_id,
                'doctor_id' => $technicalOrder->employee_id,
                'type' => Invoice::TYPE_TECHNICAL_ORDER,
                'amount' => 0,
                'appointment_id' => (Yii::$app->request->post('appointment_id') !== null) ? Yii::$app->request->post('appointment_id') : 0,

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

    public function actionUpdateAjax()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax) {
            $technicalOrder = TechnicalOrder::findOne(Yii::$app->request->post('technical_order_id'));

            $technicalOrder->employee_id = Yii::$app->request->post('employee_id');
            $technicalOrder->comment = Yii::$app->request->post('comment');
            $technicalOrder->delivery_date = date('Y-m-d', strtotime(Yii::$app->request->post('delivery_date')));
            $technicalOrder->changeStatus(Yii::$app->request->post('status'));


            $invoice_items = [];
//            $invoice = new Invoice([
//                'patient_id' => $technicalOrder->invoice->patient_id,
//                'doctor_id' => $technicalOrder->employee_id,
//                'type' => Invoice::TYPE_TECHNICAL_ORDER,
//                'amount' => 0,
//                'appointment_id' => (Yii::$app->request->post('appointment_id') !== null) ? Yii::$app->request->post('appointment_id') : 0,
//            ]);

            $invoice = Invoice::findOne($technicalOrder->technical_order_invoice_id);
            $invoice->doctor_id = $technicalOrder->employee_id;
            $summ = 0;
            foreach (Yii::$app->request->post('items') as $item) {
                $invoice_item = new InvoiceItems();
                $invoice_item->prices_id = $item['id'];
                $invoice_item->quantity = $item['quantity'];
                $summ += $invoice_item->summary;
                $invoice_items[] = $invoice_item;
            }
            $invoice->amount_payable = $invoice->amount = $summ;

            $transaction = InvoiceItems::getDb()->beginTransaction();
            try {
                $invoice->save(false);
                $technicalOrder->save(false);
                foreach ($invoice->invoiceItems as $invoiceItem) {
                    $invoiceItem->delete();
                }
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
