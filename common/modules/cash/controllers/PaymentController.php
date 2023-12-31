<?php

namespace common\modules\cash\controllers;

use common\modules\cash\models\Cashbox;
use common\modules\cash\models\Payment;
use common\modules\catalogs\models\PaymentType;
use common\modules\invoice\models\Invoice;
use common\modules\invoice\models\InvoiceSearch;
use common\modules\patient\models\Patient;
use common\modules\patient\models\PatientSearch;
use common\modules\sale\models\GiftCard;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Response;

class PaymentController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        $cashbox = Cashbox::getCurrentCashBox();
        if ($cashbox == null or $cashbox->isClosed()) {
            $this->redirect('/cash/manage/start');
        }

        return true; // or false to not run the action
    }

    public function actionGetDebt()
    {

        $searchModel = new InvoiceSearch(['searchType' => InvoiceSearch::SEARCH_TYPE_DEBT]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('get-debt', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    public function actionGetDebtOrthodontics($patient_id)
    {
        $invoice = new Invoice();
        $patient = Patient::findOne($patient_id);
        $schemeOrthodontics = $patient->schemeOrthodontics;
        $invoice->doctor_id = $schemeOrthodontics->sotr;
        $invoice->patient_id = $patient_id;
        $invoice->type = Invoice::TYPE_ORTHODONTICS;
        $invoice->amount = $schemeOrthodontics->summ_month;
        $invoice->amount_payable = $schemeOrthodontics->summ_month;
        $invoice->appointment_id = 0;

        $payment = new Payment();

        $payment->type = 1;
        $payment->date = date('Y-m-d');
        $payment->time = date('H:i:s');
        if ($payment->load(Yii::$app->request->post()) && $payment->validate()) {
            $invoice->save(false);
            $payment->dnev = $invoice->id;
            $payment->makePayment();
            return $this->render('redirect_after_pay', ['payment' => $payment,]);
        }
        return $this->render('pay', [
            'payment' => $payment,
            'invoice' => $invoice
        ]);
    }

    public function actionGetPrepayment()
    {
        $searchModel = new PatientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('get-prepayment', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPayPrepayment($patient_id)
    {
        $invoice = new Invoice();

        $invoice->doctor_id = Yii::$app->user->identity->employe_id;
        $invoice->patient_id = $patient_id;
        $invoice->type = Invoice::TYPE_PREPAYMENT;
        $invoice->amount = 0;
        $invoice->amount_payable = 0;
        $invoice->appointment_id = 0;

        $payment = new Payment();

        $payment->type = 1;
        $payment->date = date('Y-m-d');
        $payment->time = date('H:i:s');
        if ($payment->load(Yii::$app->request->post()) && $payment->validate()) {
            $invoice->save(false);
            $payment->dnev = $invoice->id;
            $payment->makePayment();
            return $this->render('redirect_after_pay', ['payment' => $payment,]);
        }
        return $this->render('pay', [
            'payment' => $payment,
            'invoice' => $invoice
        ]);

    }

    public function actionOrthodontics()
    {
        $searchModel = new PatientSearch(['type' => PatientSearch::TYPE_ORTHODONTICS]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('orthodontics', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionToday()
    {
        $invoices = Cashbox::getTodayInvoices();

        return $this->render('today', [
            "invoices" => $invoices,
        ]);
    }

    public function actionPay($invoice_id)
    {
        $payment = new Payment();
        $payment->dnev = $invoice_id;
        $payment->type = 1;
        $payment->date = date('Y-m-d');
        $payment->time = date('H:i:s');
        $invoice = Invoice::findOne($invoice_id);
        $isValidate = true;
        if ($invoice->type == Invoice::TYPE_GIFT_CARDS) {
            $giftCard = new GiftCard();
            $giftCard->type = GiftCard::TYPE_CASH;
            $giftCard->cliniс_gift = 0;
            $giftCard->balance = 0;
            if (!($giftCard->load(Yii::$app->request->post()) && $giftCard->validate())) {

                $isValidate = false;
            }
        } else {
            $giftCard = null;
        }

        $payment->load($payment->load(Yii::$app->request->post()));
        $giftCardForPay=null;
        if ($payment->VidOpl == PaymentType::TYPE_GIFT_CARD) {
            $giftCardForPay = GiftCard::findOne(['number' => Yii::$app->request->post('gift_card_number')]);
            if (!$giftCardForPay) {
                Yii::$app->session->setFlash('error', 'Подарочная карта с номером '.Yii::$app->request->post('gift_card_number').' не найдена');
                $isValidate = false;
            }elseif ($giftCardForPay->balance < $payment->vnes) {
                Yii::$app->session->setFlash('error', 'Сумма не может быть больше остатка баланса карты  ' . $giftCard->balance . ' р.');
                $isValidate = false;
            }
        }

        if ($isValidate && $payment->load(Yii::$app->request->post()) && $payment->validate() && $payment->makePayment()) {
            if ($giftCard) {
                $giftCard->balance = $payment->vnes;
                $giftCard->save(false);
            }
            if ($giftCardForPay) {
                $giftCardForPay->balance -= $payment->vnes;
                $giftCardForPay->save(false);
            }
            return $this->render('redirect_after_pay', ['payment' => $payment,]);
        }

        return $this->render('pay', [
            'payment' => $payment,
            'invoice' => $invoice,
            'giftCard' => $giftCard,
        ]);

    }

    public function actionPaymentTypeForm()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {

            $html = '';
            switch (Yii::$app->request->post('payment_type')) {
                case PaymentType::TYPE_AGREEMENT:
                    $patient = Patient::findOne(Yii::$app->request->post('patient_id'));
                    $html = 'Организация: ' . $patient->agreement->company->nazv;
                    break;
                case PaymentType::TYPE_PREPAYMENT:
                    $patient = Patient::findOne(Yii::$app->request->post('patient_id'));
                    $html = 'Остаток аванса: ' . $patient->prepayment->avans . ' р.';
                    break;
                case PaymentType::TYPE_FULL_DISCOUNT:
                    $patient = Patient::findOne(Yii::$app->request->post('patient_id'));
                    $html = 'Номер карты: ' . $patient->fullDiscountCard->num;
                    break;
                case PaymentType::TYPE_GIFT_CARD:
                    $html = 'Номер карты: ' . Html::input('text', 'gift_card_number', '', ['id' => 'gift_card_number']);
                    break;

            }


            return $html;
        }
    }

    public function actionPrint($payment_id)
    {
        $this->layout = '@frontend/views/layouts/print';
        return $this->render('payment_print', ['payment' => Payment::findOne($payment_id)]);
    }
    public function actionAktPrint($payment_id)
    {
        $this->layout = '@frontend/views/layouts/print';
        return $this->render('akt_print', ['payment' => Payment::findOne($payment_id)]);
    }
    public function actionView($payment_id)
    {
        return $this->render('view', ['payment' => Payment::findOne($payment_id)]);
    }
}
