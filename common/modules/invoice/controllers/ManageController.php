<?php

namespace common\modules\invoice\controllers;

use common\modules\invoice\models\InvoiceForSchemeOrthodontics;
use common\modules\invoice\models\InvoiceSearch;
use common\modules\invoice\models\SchemeOrthodontics;
use common\modules\invoice\models\InvoiceItems;
use common\modules\invoice\models\Invoice;
use common\modules\invoice\widgets\form\InvoiceFormWidget;
use common\modules\patient\models\Patient;
use common\modules\userInterface\models\UserInterface;
use yii\web\Response;
use Yii;

class ManageController extends \yii\web\Controller
{
    public function actionCreate($patient_id, $appointment_id = 0, $invoice_type = Invoice::TYPE_MANIPULATIONS, $employee_choice = false)
    {

        return $this->render('create', [
            'patient_id' => $patient_id,
            'appointment_id' => $appointment_id,
            'invoice_type' => $invoice_type,
            'employee_choice' => $employee_choice,
        ]);
    }

    public function actionCreateOrthodontics($patient_id, $appointment_id = 0)
    {
        $schemeOrthodontics = Patient::findOne($patient_id)->schemeOrthodontics;
        if ($schemeOrthodontics != null) {

            $invoice = new Invoice();

            $invoice->doctor_id = $schemeOrthodontics->sotr;
            $invoice->patient_id = $patient_id;
            $invoice->type = Invoice::TYPE_ORTHODONTICS;
            $invoice->amount = $schemeOrthodontics->getAmount();

//            $invoice->amount = $schemeOrthodontics->summ_month;
            $invoice->amount_payable = $invoice->amount;
            $invoice->appointment_id = $appointment_id;
            $invoice->save(false);
            $invoiceForSchemeOrthodontics = new InvoiceForSchemeOrthodontics();
            $invoiceForSchemeOrthodontics->invoice_id = $invoice->id;
            $invoiceForSchemeOrthodontics->scheme_orthodontics_id = $schemeOrthodontics->id;
            $invoiceForSchemeOrthodontics->save(false);
            Yii::$app->session->setFlash('success', 'Оплата за ортодонтию успешно создана');

        } else {
            Yii::$app->session->setFlash('error', 'Невзможно найти схему для пациента');

        }
        $this->redirect('/');
    }

    public function actionGetAjaxTable()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $html = '';
            $invoice = Invoice::findOne(Yii::$app->request->post('invoice_id'));

            $html = '    
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Счёт №' . $invoice->id . ' от ' . $invoice->date . '</h4>
                                <div class="row">
                                    <div class="col-lg-6">
                                        Врач: ' . $invoice->getEmployeeFullName() . '</br>
                                        Пациент: ' . $invoice->getPatientFullName() . '
                                    </div>
                                    <div class="col-lg-6">
                                        ' . InvoiceFormWidget::getEarlyPaymentTable($invoice->id) . '
                                    </div>    
                                </div>
                                '.InvoiceFormWidget::getTechnicalOrderInfo($invoice->id).'    
                            </div>
                            <div class="modal-body">
                                ' . InvoiceFormWidget::getInvoiceTable($invoice->id) . '
                            </div>
                            <div class="modal-footer">
                                <a href="/invoice/manage/print?invoice_id=' . $invoice->id . '" class="btn btn-success" target="_blank">Печать</a>
                                 <a href="/invoice/manage/print-akt?invoice_id=' . $invoice->id . '" class="btn btn-success" target="_blank">Печать акта</a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>                               
                            </div>
                        </div>
                    </div>';
            return $html;
        }
    }

    public function actionGetInvoiceItems()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $invoice = Invoice::findOne(Yii::$app->request->post('invoice_id'));
            $invoiceItems=[];
            foreach ($invoice->invoiceItems as $invoiceItem){
                $item['title']=$invoiceItem->prices->pricelistItems->title;
                $item['id']=$invoiceItem->prices_id;
                $item['price']=$invoiceItem->prices->price;
                $item['quantity']=$invoiceItem->quantity;
                $invoiceItems[]=$item;
            }

        return $invoiceItems;
        }
    }

    public function actionSaveAjax()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {

            $invoice_items = [];
            $invoice = new Invoice();

            $invoice->doctor_id = Yii::$app->request->post('doctor_id');

            $invoice->patient_id = Yii::$app->request->post('patient_id');
            $invoice->type = Yii::$app->request->post('invoice_type');

            if (Yii::$app->request->post('appointment_id') !== null) {
                $invoice->appointment_id = Yii::$app->request->post('appointment_id');
            }
            $invoice->amount = 0;
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
                foreach ($invoice_items as $invoice_item) {
                    $invoice_item->invoice_id = $invoice->id;
                    $invoice_item->save(false);
                }
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Счёт успешно сохранён.');
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
            return 'Запрос принят.';
        }
    }
    public function actionUpdateAjax()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {

            $invoice_items = [];
            $invoice = Invoice::findOne(Yii::$app->request->post('invoice_id'));

            $invoice->amount = 0;
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
                foreach ($invoice->invoiceItems as $invoiceItem){
                    $invoiceItem->delete();
                }
                foreach ($invoice_items as $invoice_item) {
                    $invoice_item->invoice_id = $invoice->id;
                    $invoice_item->save(false);
                }
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Счёт успешно сохранён.');
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
            return 'Запрос принят.';
        }
    }

    public function actionPrint($invoice_id)
    {
        $this->layout = '@frontend/views/layouts/print';
        return $this->render('print', ['invoice' => Invoice::findOne($invoice_id)]);
    }

    public function actionPrintAkt($invoice_id)
    {
        $this->layout = '@frontend/views/layouts/print';

        return $this->render('print-akt', ['invoice' => Invoice::findOne($invoice_id)]);
    }

    public function actionIndex()
    {

        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }
    public function actionUpdate($invoice_id,$employee_choice=false){
       $invoice= Invoice::findOne($invoice_id);
        return $this->render('update', [
            'patient_id' => $invoice->patient_id,
            'appointment_id' =>$invoice->appointment_id,
            'invoice_type' => $invoice->type,
            'employee_choice' => $employee_choice,
            'invoice_id'=>$invoice_id,
        ]);
    }

    public function actionDelete($id)
    {
        $invoice = Invoice::findOne($id);
//        UserInterface::getVar($invoice->hasPayments());

        if ($invoice->hasPayments()) {
            Yii::$app->session->setFlash('danger', 'По счету имеется оплата, поэтому удаление невозможно.');
        } elseif ($invoice->hasTachnicalOrder()) {
            Yii::$app->session->setFlash('danger', 'По счету имеется заказ-наряд, поэтому удаление невозможно.');
        }
        else {
            Yii::$app->session->setFlash('success', 'Счёт успешно удалён');
            $invoice->delete();
        }
        return $this->redirect('index');
    }
}