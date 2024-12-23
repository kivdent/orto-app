<?php

namespace common\modules\statistics\models;

use common\modules\catalogs\models\CompletedDiagnoses;
use common\modules\employee\models\Employee;
use common\modules\invoice\models\Invoice;
use common\modules\patient\models\Patient;
use common\modules\pricelists\models\PricelistItems;
use common\modules\schedule\models\Appointment;
use common\modules\schedule\models\AppointmentsDay;
use common\modules\userInterface\models\UserInterface;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 *
 * @property-read ActiveQuery $appointmentsQuery
 * @property-read ActiveQuery $patientsQuery
 * @property-read int $patientsCount
 * @property-read Patient[] $patients
 * @property-read int $firstAppointmentCount
 * @property-read float $visitCost
 * @property-read mixed $revenuePerIndividual
 * @property-read float $visitsByIndividual
 * @property-read float $firstToAll
 * @property-read float $loadByVisit
 * @property-read string $loadStatus
 * @property-read float $loadByTime
 * @property-read float $workingHoursWithPatients
 * @property-read int $appointmentsCount
 * @property-read \yii\db\ActiveQuery $invoicesQuery
 * @property-read int $invoicesSummary
 * @property-read mixed $pricelistItemsQuery
 * @property-read null|float $volume
 * @property-read float $completeness
 * @property-read float $appointmentsHoursWithPatients
 * @property-read null|float $loadByAppointmentTime
 * @property int $casesCount
 */
class KaldinReport extends Model

{

    /**
     * @var Employee
     */
    public $doctor;

    /**
     * @var Appointment[]
     */
    public $appointments;
    /**
     * @var Patient[]
     */
    public $patients;
    public $pricelistItems = [];
    public $startDate;
    public $period;
    public $workingHours;

    /**
     * @var Invoice
     */
    private $invoices;
    /**
     * @var mixed
     */
    public $completedDiagnoses = [];

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->setWorkingHours();
        $this->setInvoices();
        $this->setAppointments();
        $this->setPatients();
        $this->setPriceListItems();
        $this->setCompletedDiagnoses();

    }

    private function setWorkingHours()
    {
        $this->workingHours = 0;
        $date = strtotime($this->startDate);

        for ($i = 1; $i <= $this->period; $i++) {
            $appointmentsDay = AppointmentsDay::getAppointmentsDayForDoctor($this->doctor->id, $date);
            $this->workingHours += ($appointmentsDay ? $appointmentsDay->durationSeconds : 0) / 3600;
//            $date = strtotime(date('d.m.Y', $date) . ' +1 day');
            $date += 24 * 60 * 60;
        }

    }

    /**
     * @return ActiveQuery
     */
    private function getInvoicesQuery(): ActiveQuery
    {
        $startDate = date('Y-m-1', strtotime($this->startDate));
        $endDate = date('Y-m-t', strtotime($this->startDate));

        return Invoice::find()
            ->where("doctor_id =" . $this->doctor->id)
            ->andWhere('created_at<="' . $endDate . '"')
            ->andWhere('created_at>="' . $startDate . '"');
    }

    public function setInvoices()
    {

        $this->invoices = $this->getInvoicesQuery()->all();

    }

    /**
     * @return int
     */

    public function getInvoicesSummary(): int
    {
        $invoicesSummary = 0;

        foreach ($this->invoices as $invoice) {
            $invoicesSummary += $invoice->amount_payable;
        }

        return $invoicesSummary;
    }


    public function setAppointments(): void
    {
        $this->appointments = [];

        $this->getAppointmentsQuery();
        $this->appointments = array_merge($this->appointments, $this->getAppointmentsQuery()->all());
        /** @var Appointment $appointment */
        foreach ($this->appointments as $appointment) $appointment->setInitialDateFlag();

    }

    /**
     * @return int
     */

    public function getAppointmentsCount(): int
    {

        return count($this->appointments);

    }

    /**
     * @return ActiveQuery
     */
    private function getAppointmentsQuery(): \yii\db\ActiveQuery
    {

        $startDate = date('Y-m-1', strtotime($this->startDate));
        $endDate = date('Y-m-t', strtotime($this->startDate));

        return Appointment::find()
            ->leftJoin('daypr', 'daypr.id=nazn.dayPR')
            ->leftJoin('klinikpat', 'klinikpat.id=nazn.PatID')
            ->where('daypr.vrachID =' . $this->doctor->id)
            ->andWhere(['klinikpat.card_type' => Patient::PATIENT_TYPE_PATIENT])
            ->andWhere('nazn.status ="' . Appointment::STATUS_ACTIVE . '"')
            ->andWhere('daypr.date<="' . $endDate . '"')
            ->andWhere('daypr.date>="' . $startDate . '"');
    }

    /**
     * @return int
     */
    public function getPatientsCount(): int
    {
        return count($this->patients);
    }

    /**
     * @return Patient[]
     */
    public function getPatients(): array
    {
        return $this->getPatientsQuery()->all();
    }

    /**
     * @return ActiveQuery
     */
    private function getPatientsQuery(): ActiveQuery
    {

        $startDate = date('Y-m-1', strtotime($this->startDate));
        $endDate = date('Y-m-t', strtotime($this->startDate));

        return Patient::find()
            ->leftJoin('nazn', 'klinikpat.id=nazn.PatID')
            ->leftJoin('daypr', 'daypr.id=nazn.dayPR')
            ->where('daypr.vrachID =' . $this->doctor->id)
            ->andWhere(['klinikpat.card_type' => Patient::PATIENT_TYPE_PATIENT])
            ->andWhere('nazn.status ="' . Appointment::STATUS_ACTIVE . '"')
            ->andWhere('daypr.date<="' . $endDate . '"')
            ->andWhere('daypr.date>="' . $startDate . '"');
    }

    /**
     * @return int
     */
    public function getFirstAppointmentCount(): int
    {
        $count = 0;
        /** @var Appointment $appointment */
        foreach ($this->appointments as $appointment) {
            if ($appointment->initialDateFlag) $count++;
        }
        return $count;
    }

    /**
     * @return float|null
     */
    public function getVisitCost()
    {
        return $this->appointmentsCount > 0 ? round($this->invoicesSummary / $this->appointmentsCount, 2) : null;
    }

    /**
     * @return float|null
     */
    public function getRevenuePerIndividual(): ?float
    {
        return $this->patientsCount ? round($this->invoicesSummary / $this->patientsCount, 2) : null;
    }

    /**
     * @return void
     */
    private function setPatients(): void
    {
        $this->patients = $this->getPatientsQuery()->all();
    }

    /**
     * @return float|null
     */
    public function getVisitsByIndividual(): ?float
    {

        return $this->appointmentsCount > 0 ? round($this->appointmentsCount / $this->patientsCount, 2) : null;
    }

    /**
     * @return float|null
     */
    public function getFirstToAll(): ?float
    {
        return $this->appointmentsCount > 0 ? round($this->firstAppointmentCount / $this->appointmentsCount * 100, 2) : null;
    }

    /**
     * @return float|null
     */
    public function getLoadByVisit(): ?float
    {
        return $this->workingHours ? round($this->appointmentsCount / $this->workingHours * 100, 2) : null;
    }

    /**
     * @return string
     */
    public function getLoadStatus(): string
    {
        return $this->loadByAppointmentTime > 80 ? 'Перегруз' : 'Недогруз';
    }

    /**
     * @return float
     */
    public function getWorkingHoursWithPatients(): float
    {
        $duration =0;
        foreach ($this->appointments as $appointment) {
            $duration += $appointment->durationSeconds;
        }
        $duration = round($duration / 3600, 2);
        return $duration;
    }

    /**
     * @return float
     */
    public function getAppointmentsHoursWithPatients(): float
    {
        $duration =0;
        foreach ($this->appointments as $appointment) {

            $duration += $appointment->appointmentDurationSeconds;

        }

        $duration = round($duration / 3600, 2);
        return $duration;

    }

    /**
     * @return float|null
     */
    public function getLoadByTime(): ?float
    {
        return $this->workingHours ? round($this->workingHoursWithPatients / $this->workingHours * 100, 2) : null;
    }

    /**
     * @return float|null
     */
    public function getVolume(): ?float
    {

        return $this->patientsCount ? round($this->casesCount / $this->patientsCount, 2) : null;
    }

    /**
     * @return int
     */
    public function getCasesCount(): int
    {
        return 0;//count($this->cases);
    }

    private function setPriceListItems()
    {
        // $this->pricelistItems = $this->getPricelistItemsQuery()->all();

        /** @var Invoice $invoice */
        foreach ($this->invoices as $invoice) {
            /** @var PricelistItems $invoiceItem */
            foreach ($invoice->invoiceItems as $invoiceItem) {
                $id = $invoiceItem->prices->pricelistItems->id;
                if (isset($this->pricelistItems[$id])) {
                    $this->pricelistItems[$id]['count'] += $invoiceItem->quantity;
                } else {
                    $this->pricelistItems[$id]['count'] = $invoiceItem->quantity;
                    $this->pricelistItems[$id]['title'] = $invoiceItem->prices->pricelistItems->title;
                }
            }
        }
    }


    /**
     * @return float|null
     */
    public function getLoadByAppointmentTime(): ?float
    {
        return  $this->workingHours ? round($this->appointmentsHoursWithPatients / $this->workingHours * 100, 2) : null;

    }

    /**
     * @return PricelistItems
     */
    private function getPricelistItemsQuery(): ActiveQuery
    {

        $startDate = date('Y-m-1', strtotime($this->startDate));
        $endDate = date('Y-m-t', strtotime($this->startDate));

        return PricelistItems::find()
            ->leftJoin('')
            ->where("invoice.doctor_id =" . $this->doctor->id)
            ->andWhere('invoice.created_at<="' . $endDate . '"')
            ->andWhere('invoice.created_at>="' . $startDate . '"');
    }


    public function setCompletedDiagnoses(): void
    {
        $completedDiagnoses = CompletedDiagnoses::find()->all();
        $this->completedDiagnoses['summary'] = 0;
        /** @var CompletedDiagnoses $completedDiagnosis */
        $pricelistItemsIds = array_keys($this->pricelistItems);
        foreach ($completedDiagnoses as $completedDiagnosis) {

            $this->completedDiagnoses[$completedDiagnosis->id]['title'] = $completedDiagnosis->title;
            $this->completedDiagnoses[$completedDiagnosis->id]['count'] = 0;

            $pricelistItemsIdsForCompletedDiagnoses = ArrayHelper::getColumn($completedDiagnosis->completedDiagnosesForManipulations, 'pricelist_items_id');

            foreach ($this->pricelistItems as $key => $pricelistItem) {
                if (in_array($key, $pricelistItemsIdsForCompletedDiagnoses)) {
                    $this->completedDiagnoses[$completedDiagnosis->id]['count'] += $pricelistItem['count'];
                    $this->completedDiagnoses['summary'] += $pricelistItem['count'];
                }
            }
        }
    }


    /**
     * @return float|null
     */
    public function getCompleteness(): ?float
    {
        $completeness = $this->patientsCount ? round($this->completedDiagnoses['summary'] / $this->patientsCount, 2) : null;
        return $completeness;
    }
}