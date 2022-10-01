<?php


namespace common\modules\userInterface\widgets;

use common\modules\invoice\models\TechnicalOrder;
use yii\helpers\Html;
use common\modules\invoice\models\Invoice;
use common\modules\userInterface\models\UserInterface;
use yii\base\Widget;
use Yii;

/**
 * Description of ScheduleAlertsWidgets
 *
 * @author kivdent
 */
class ScheduleAlertsWidgets extends Widget
{

    /**
     * @var $alerts array
     */
    public $patient_id;
    public $employee_id;
    public $alerts = [];

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setAlerts();
    }

    public function run()
    {
        return $this->render('_scheduleAlerts', [
            'alerts' => $this->alerts,
        ]);
    }

    public function setAlerts()
    {
        $this->alerts[] = $this->getInvoicesForTechnicalOrder();
        $this->alerts[] = $this->getUnclosedTechnicalOrder();
        $this->alerts[] = $this->getDebt();

    }

    private function getInvoicesForTechnicalOrder()
    {
        $date_month_ago = date('Y-m-d', strtotime('-1 month'));
        $invoices = Invoice::getInvoicesWithTechnicalItemsCompliances($this->employee_id, $this->patient_id, $this->getStartDate(), date('Y-m-d'));

        foreach ($invoices as $invoice) {
            if (!$invoice->hasTechnicalOrderForInvoice()) {
                return Html::a("Выпишите заказ-наряд",
                    ['/patient/invoices', 'patient_id' => $this->patient_id],
                    ['class' => 'btn btn-xs btn-danger', 'target' => '_blank']);
            }
        }
    }

    private function getUnclosedTechnicalOrder()
    {

        $unclosedTechnicalOrders=TechnicalOrder::getUnclosed($this->employee_id, $this->patient_id, $this->getStartDate(), date('Y-m-d'));
        return empty($unclosedTechnicalOrders)?'':Html::a("Незакрытые заказ-наряды",
            ['/patient/technical-order', 'patient_id' => $this->patient_id],
            ['class' => 'btn btn-xs btn-danger', 'target' => '_blank']);
    }
    private function getStartDate($monthsAgo=1){
        return date('Y-m-d', strtotime('-'.$monthsAgo.' month'));
    }

    private function getDebt()
    {
        return empty(Invoice::getPatientDebts($this->patient_id))?'':Html::a("Долги пациента",
            ['/patient/invoices', 'patient_id' => $this->patient_id],
            ['class' => 'btn btn-xs btn-danger', 'target' => '_blank']);;
    }
}
