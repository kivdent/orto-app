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
use common\modules\invoice\models\TechnicalOrder;
use common\modules\invoice\widgets\modalTable\InvoiceModalWidget;
use common\modules\userInterface\models\UserInterface;
use yii\base\Model;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class DailyReport
 * @package common\modules\reports\models
 *
 * @property Employee $employee
 */
class DailyReport extends Model
{
    const TYPE_OF_REPORT_TECHNICAL_ORDER = Invoice::TYPE_TECHNICAL_ORDER;
    const TYPE_OF_REPORT_TECHNICAL_COMPLETED = 'technical_order_completed';
    const TYPE_OF_REPORT_TECHNICAL_CURRENT = 'technical_order_current';

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
        'actions' => 'Действия',
    ];

    public $invoices;
    public $payments;

    public $invoice_type;

    public static function getToday($employee_id, $invoice_type = Invoice::TYPE_MANIPULATIONS)
    {
        return self::getReportForDate($employee_id, date('Y-m-d'), $invoice_type);
    }

    public static function getReportForDate($employee_id, $date, $invoice_type)
    {
        $report = new self(['employee' => Employee::findOne($employee_id), 'date' => $date, 'invoice_type' => $invoice_type]);
        $report->setTable();
        $report->invoice_summary = $report->getInvoiceSummary();
        $report->coefficient_summary = $report->getCoefficientSummary();

        return $report;
    }

    public static function getTest($employee_id)
    {
        $report = new self([
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
                    'actions' => 'Действия',
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
                        ) . $invoice->getPatientFullName(),
                    'date' => $invoice->date,
                ];
                $row['invoice_sum'] = InvoiceModalWidget::widget(['invoice_id' => $invoice->id]);
//                switch ($this->invoice_type) {
//                    case Employee::POSITION_TECHNICIANS:
//                        $row['invoice_sum'] .= $invoice->coefficientSummary . '';
//                        break;
//                    default:
//                        $row['invoice_sum'] .= $invoice->amount_payable . ' р. ';
//                        break;
                $row['invoice_sum'] .= $invoice->amount_payable . ' р. ';


                switch ($this->invoice_type) {
                    case Invoice::TYPE_TECHNICAL_ORDER:
                        $row['invoice_sum'] .= $invoice->doctorInvoiceForTechnicalOrder->amount_residual != 0 ? ' Не оплачен' : ' Оплачен';
                        break;
                    default:
                        $row['invoice_sum'] .= $invoice->amount_residual != 0 ? '(' . $invoice->amount_residual . ' р.)' : '';
                        break;
                }
                $row['payment_sum'] = 0;
                $row['payment_type'] = '';
                if ($this->employee->dolzh !== Employee::POSITION_TECHNICIANS) {

                    $row['actions'] = Html::a('Создать заказ наряд',
                        ['/invoice/technical-order/create', 'invoice_id' => $invoice->id, 'invoice_type' => Invoice::TYPE_TECHNICAL_ORDER]
                    );
                    if ($invoice->paid == 0) {
                        $row['actions'] .= '<br>' . Html::a('Редактировать',
                                ['/invoice/manage/update', 'invoice_id' => $invoice->id]
                            );
                    }
                }
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
        switch ($this->employee->dolzh) {
            case Employee::POSITION_TECHNICIANS:
                $row['invoice_sum'] .= $invoice->coefficientSummary . '';
                break;
            default:
                $row['invoice_sum'] .= $invoice->amount_payable . ' р. ';
                break;
        }
        switch ($this->employee->dolzh) {
            case Employee::POSITION_TECHNICIANS:
                $row['invoice_sum'] .= $invoice->doctorInvoiceForTechnicalOrder->amount_residual != 0 ? ' Не оплачен' : ' Оплачен';
                break;
            default:
                $row['invoice_sum'] .= $invoice->amount_residual != 0 ? '(' . $invoice->amount_residual . ' р.)' : '';
                break;
        }

//        $row['invoice_sum'] .= $invoice->amount_residual != 0 ? '(' . $invoice->amount_residual . ' р.)' : '';
        $row['payment_sum'] = $payment->vnes;
        $row['payment_type'] = $payment->typeName;
        if ($this->employee->dolzh !== Employee::POSITION_TECHNICIANS) {
            $row['actions'] = Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>',
                ['/invoice/technical-order/create', 'invoice_id' => $invoice->id, 'invoice_type' => Invoice::TYPE_TECHNICAL_ORDER,
                    ['class' => 'btn btn-primary btn-xs',]
                ]
            );
            if ($invoice->paid == 0) {
                $row['actions'] .= '<br>' . Html::a(
                    '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',
                        ['/invoice/manage/update', 'invoice_id' => $invoice->id],
                        ['class' => 'btn btn-primary btn-xs',]
                    );
            }
        }
        $this->table[] = $row;
    }

    public function getInvoices()
    {


        return Invoice::find()
            ->where(['doctor_id' => $this->employee->id])
            ->andWhere(Invoice::getDateExpression($this->date))
            ->andWhere(['type' => $this->setInvoicesType()])
            ->all();
    }

    private function getPaymentsForInvoice($invoice_id)
    {
        return Payment::find()->where(['dnev' => $invoice_id, 'date' => $this->date])->all();
    }

    public static function getDailyReport($employee_id, $date, $report_type)
    {

        switch ($report_type) {
            case DailyReport::TYPE_OF_REPORT_TECHNICAL_ORDER:
                $daily_report = DailyReportTechnicalOrder::getReportForDate($employee_id, $date, $report_type);
                break;
            case DailyReport::TYPE_OF_REPORT_TECHNICAL_COMPLETED:
                $daily_report = DailyReportTechnicalOrderCompleted::getReportForDate($employee_id, $date, $report_type);
                break;
            case DailyReport::TYPE_OF_REPORT_TECHNICAL_CURRENT:
                $daily_report = DailyReportTechnicalOrderCurrent::getReportForDate($employee_id, $date, $report_type);
                break;
            default:
                $daily_report = DailyReport::getReportForDate($employee_id, $date, $report_type);
                break;
        }
        return $daily_report;
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
        $this->setInvoicesType();
        $payments = Payment::find()
            ->select('`oplata`.`*`')
            ->where(['date' => $this->date])
            ->innerJoinWith(['invoice' => function ($query) {
                $query->onCondition(Invoice::getDateExpression($this->date, '<>'));

            }])
            ->andWhere(['invoice.doctor_id' => $this->employee->id])
            ->andWhere(['invoice.type' => $this->setInvoicesType()])->all();
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
        $sum = 0;

        switch ($this->employee->dolzh) {
            case Employee::POSITION_TECHNICIANS:
                $sum = array_sum(array_column($this->getInvoices(), 'salarySum'));
                break;
            default:
                $sum = array_sum(array_column($this->getInvoices(), 'amount_payable'));
                break;
        }
        return $sum;
    }

    public function getPaymentSummary()
    {
        return array_sum(array_column($this->getPayments(), 'vnes'));
    }

    public function getCoefficientSummary()
    {
        $sum = 0;
        /* @var $payment Payment */
        switch ($this->employee->dolzh) {
            case Employee::POSITION_TECHNICIANS:
                $payments = Payment::find()
                    ->select('oplata.dnev')
                    ->where(['oplata.date' => $this->date])
                    ->innerJoinWith(['invoice' => function ($query) {
                        $query->innerJoinWith(['technicalOrderForInvoice' => function ($q) {
                            $q->onCondition([TechnicalOrder::tableName() . '.employee_id' => $this->employee->id]);
                        }]);
                    }])
                    ->groupBy('oplata.dnev')
                    ->all();
                break;
            default:
                $payments = Payment::find()
                    ->select('oplata.dnev')
                    ->where(['oplata.date' => $this->date])
                    ->joinWith('invoice')
                    ->andWhere(['invoice.doctor_id' => $this->employee->id])
                    ->andWhere([Invoice::tableName() . '.type' => $this->setInvoicesType()])
                    ->groupBy('oplata.dnev')
                    ->all();
                break;
        }

        if ($payments) {
            foreach ($payments as $payment) {
                if ($this->date == $payment->invoice->getLastPaymentDate()
                    && $payment->invoice->amount_residual == 0) {
                    switch ($this->employee->dolzh) {
                        case Employee::POSITION_TECHNICIANS:
                            $sum += $payment->invoice->technicalOrderInvoice->salarySum;
                            break;
                        default:
                            $sum += $payment->invoice->salarySum;
                            break;
                    }
                }
            }
        }
        return $sum;
    }

    private function setInvoicesType()
    {
        $type = [];
        switch ($this->employee->dolzh) {
            case Employee::POSITION_TECHNICIANS:
                $type = Invoice::TYPE_TECHNICAL_ORDER;
                break;
            default:
                $type = [Invoice::TYPE_MANIPULATIONS, Invoice::TYPE_ORTHODONTICS];
                break;
        }
//        switch ($this->invoice_type) {
//            case  Invoice::TYPE_TECHNICAL_ORDER:
//                $type = Invoice::TYPE_TECHNICAL_ORDER;
//                break;
//            default:
//                $type = [Invoice::TYPE_MANIPULATIONS, Invoice::TYPE_ORTHODONTICS];
//                break;
//        }
        return $type;
    }
}