<?php
/**
 * @property \common\modules\invoice\models\Invoice $invoices
 * @property \common\modules\cash\models\Payment $payments
 * @property \common\modules\employee\models\Employee $employee
 */

namespace common\modules\reports\models;


use common\modules\cash\models\Payment;
use common\modules\employee\models\Employee;
use common\modules\invoice\models\Invoice;
use common\modules\invoice\widgets\modalTable\InvoiceModalWidget;
use yii\base\Model;
use yii\db\Expression;
use yii\helpers\Html;


class DailyReport extends Model
{

    public $employee;
    public $date;

    public $invoice_summary = 0;
    public $payment_summary = 0;
    public $coefficient_summary = 0;

    public $table = [];
    public $labels = [
        'patient' => 'Пациент',
        'date' => 'Дата чека',
        'invoice_sum' => 'Сумма чека(Долг)',
        'payment_sum' => 'Сумма оплат за дату',
        'payment_type' => 'Вид оплаты',
    ];

    public $invoices;
    public $payments;

    public static function getToday($employee_id)
    {
        return self::getReportForDate($employee_id, date('Y-m-d'));
    }

    public static function getReportForDate($employee_id, $date)
    {
        $report = new DailyReport(['employee' => Employee::findOne($employee_id), 'date' => $date]);
        $report->setTable();
        $report->invoice_summary = $report->getInvoiceSummary();
        $report->coefficient_summary = $report->getCoefficientSummary();

        return $report;
    }

    public static function getTest($employee_id)
    {
        $report = new DailyReport([
            'date' => date('Y-m-d'),
            'employee' => Employee::findOne($employee_id),
            'invoice_summary' => '1000',
            'coefficient_summary' => '2000',
            'table' => [
                [
                    'patient' => 'Пациент',
                    'date' => 'Дата чека',
                    'invoice_sum' => 'Сумма чека(Долг)',
                    'payment_sum' => 'Сумма оплаты за дату',
                    'payment_type' => 'Вид оплаты:',
                ]
            ],
            'labels' => [
                'patient' => 'Пациент',
                'date' => 'Дата',
                'summ' => 'Сумма'
            ]
        ]);
        return $report;
    }

    private function setTable()
    {
        /* @var $invoice Invoice */
        foreach ($this->getInvoices() as $invoice) {
            $payments = $this->getPaymentsForInvoice($invoice->id);
            if ($payments) {
                foreach ($payments as $payment) {
                    $this->setRow($payment);
                }
            } else {
                $row = [
                    'patient' => Html::a(
                        '<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>',
                        ['/patient/manage/view', 'patient_id' => $invoice->patient_id],
                        ['class' => 'btn btn-xs btn-primary']
                    ). $invoice->getPatientFullName(),
                    'date' => $invoice->date,
                ];
                $row['invoice_sum'] = InvoiceModalWidget::widget(['invoice_id' => $invoice->id]);

                $row['invoice_sum'] .= $invoice->amount_payable . ' р. ';
                $row['invoice_sum'] .= $invoice->amount_residual != 0 ? '(' . $invoice->amount_residual . ' р.)' : '';
                $row['payment_sum'] = 0;
                $row['payment_type'] = '';
                $this->table[] = $row;
            }
        }
        foreach ($this->getPaymentsNotToday() as $payment) {
            $this->setRow($payment);
        }
    }

    private function setRow($payment)
    {
        $invoice = Invoice::findOne($payment->dnev);

        $row = [
            'patient' => Html::a(
                    '<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>',
                    ['/patient/manage/view', 'patient_id' => $invoice->patient_id],
                    ['class' => 'btn btn-xs btn-primary']
                ) . $invoice->patientFullName,
            'date' => $invoice->date,
        ];
        $row['invoice_sum'] = InvoiceModalWidget::widget(['invoice_id' => $invoice->id]);
        $row['invoice_sum'] .= $invoice->amount_payable . ' р. ';
        $row['invoice_sum'] .= $invoice->amount_residual != 0 ? '(' . $invoice->amount_residual . ' р.)' : '';

        $row['payment_sum'] = $payment->vnes;
        $row['payment_type'] = $payment->typeName;
        $this->table[] = $row;
    }

    public function getInvoices()
    {
        return Invoice::find()
            ->where(['doctor_id' => $this->employee->id])
            ->andWhere(Invoice::getDateExpression($this->date))
            ->andWhere(['<>','type',Invoice::TYPE_MATERIALS])
            ->all();
    }

    private function getPaymentsForInvoice($invoice_id)
    {
        return Payment::find()->where(['dnev' => $invoice_id, 'date' => $this->date])->all();
    }

    private function getPaymentSum($invoice_id)
    {
        $sum = 0;
        $payments = $this->getPaymentsForInvoice($invoice_id);
        if ($payments) {
            foreach ($payments as $payment) {
                $sum += $payment->vnes;
            }
        }
        return $sum;
    }

    private function getPaymentType($invoice_id)
    {
        $types = '';
        $payments = $this->getPaymentsForInvoice($invoice_id);
        if ($payments) {
            foreach ($payments as $payment) {
                $types .= $payment->typeName;
            }
        }
        return $types;

    }

    public function getPaymentsNotToday()
    {
        $payments = Payment::find()
            ->select('`oplata`.`*`')
            ->where(['date' => $this->date])
            ->innerJoinWith(['invoice' => function ($query) {
                $query->onCondition(Invoice::getDateExpression($this->date, '<>'));
            }])
            ->andWhere(['invoice.doctor_id' => $this->employee->id])->all();
        return $payments;
    }

    public function getPayments()
    {
        $payments = Payment::find()
            ->where(['oplata.date' => $this->date])
            ->joinWith('invoice')
            ->andWhere(['invoice.doctor_id' => $this->employee->id])
            ->all();
        return $payments;
    }

    public function getInvoiceSummary()
    {
        return array_sum(array_column($this->getInvoices(), 'amount_payable'));
    }

    public function getPaymentSummary()
    {
        return array_sum(array_column($this->getPayments(), 'vnes'));
    }

    public function getCoefficientSummary()
    {
        $sum = 0;
        /* @var $payment Payment */
        $payments = Payment::find()
            ->select('oplata.dnev')
            ->where(['oplata.date' => $this->date])
            ->joinWith('invoice')
            ->andWhere(['invoice.doctor_id' => $this->employee->id])
            ->groupBy('oplata.dnev')
            ->all();
        if ($payments) {
            foreach ($payments as $payment) {
                if ($this->date == $payment->invoice->getLastPaymentDate()
                    && $payment->invoice->amount_residual == 0) {
                    $sum += $payment->invoice->salarySum;
                };
            }
        }
        return $sum;
    }
}