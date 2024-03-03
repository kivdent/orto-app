<?php

namespace common\modules\recall\models;

use common\modules\patient\models\Patient;
use common\modules\userInterface\models\UserInterface;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class BirthdaysTable extends Model
{
    const MIN_SUMM = 50000;
    const MIN_APPOINTMENT = 5;
    const MAX_YEARS = 4;

    public $totalPatients = 0;
    public $table = [];
    public $labels = [
        'fullName' => 'Пациент',
        'address' => 'Адрес',
        'totalAppointments' => 'Назначений',
        'lastAppointment' => 'Последний приём',
        'totalInvoiceSumm' => 'Сумма',
    ];

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setTable();
    }

//*  @var  $Patient Patient */
    public function setTable()
    {


        $row = [];
        $patients = $this->getAllPatientsForMonth();
//        ArrayHelper::index($patients, 'id');
//
//        $patients = $this->applyFilter($patients);

//        $patients = $this->applyMinAppointmentFilter($patients);
//
//        $patients = $this->applyLastAppointmentFilter($patients);
//
//        $patients = $this->applyTotalInvoiceSummFilter($patients);

        foreach ($patients as $patient) {
            if ($this->filterPatient($patient)) {
                $row['fullName'] = Html::a($patient->fullName, ['/patient/manage/update', 'patient_id' => $patient->id], ['target' => '_blank']);
                $row['address'] = $patient->addressString;
                $row['totalAppointments'] = $patient->totalAppointments;
                $row['lastAppointment'] = UserInterface::getFormatedDate($patient->lastAppointment->appointments_day->date);
                $row['totalInvoiceSumm'] = $patient->totalInvoiceSumm;
                $this->table[] = $row;
            }
        }
        $this->totalPatients = count($this->table);
    }

    private function getAllPatientsForMonth()
    {


        return $patients = Patient::find()
            ->where("DATE_FORMAT(`klinikpat`.`dr`, '%m' )=" . date('m'))
            ->all();

    }

    private function applyLastAppointmentFilter(array $patients)
    {

        foreach ($patients as $id => $patient) {
            if (strtotime(UserInterface::getFormatedDate($patient->lastAppointment->appointments_day->date)) < strtotime(date('d.m.Y') . ' -' . self::MAX_YEARS . ' years')) {
                ArrayHelper::remove($patients, $id);
            }
        }

        return $patients;
    }

    private function applyTotalInvoiceSummFilter(array $patients)
    {
        foreach ($patients as $id => $patient) {
            if ($patient->totalInvoiceSumm < self::MIN_SUMM) {
                ArrayHelper::remove($patients, $id);
            }
        }

        return $patients;
    }

    private function applyMinAppointmentFilter(array $patients)
    {
        foreach ($patients as $id => $patient) {
            if ($patient->totalAppointments < self::MIN_APPOINTMENT) {
                ArrayHelper::remove($patients, $id);
            }
        }
        return $patients;
    }

    private function applyFilter(array $patients)
    {
        foreach ($patients as $id => $patient) {

            if (strtotime(UserInterface::getFormatedDate($patient->lastAppointment->appointments_day->date)) < strtotime(date('d.m.Y') . ' -' . self::MAX_YEARS . ' years')) {
                ArrayHelper::remove($patients, $id);
            }

            if ($patient->totalInvoiceSumm < self::MIN_SUMM) {
                ArrayHelper::remove($patients, $id);
            }

            if ($patient->totalAppointments < self::MIN_APPOINTMENT) {
                ArrayHelper::remove($patients, $id);
            }

        }

        return $patients;
    }

    private function filterPatient($patient): bool
    {
//        return !((strtotime(UserInterface::getFormatedDate($patient->lastAppointment->appointments_day->date)) < strtotime(date('d.m.Y') . ' -' . self::MAX_YEARS . ' years')) &&
//            ($patient->totalInvoiceSumm < self::MIN_SUMM) && ($patient->totalAppointments < self::MIN_APPOINTMENT));


        if ($patient->totalInvoiceSumm < self::MIN_SUMM) {
            return false;
        }

        if ($patient->totalAppointments < self::MIN_APPOINTMENT) {
            return false;
        }
        if (strtotime(UserInterface::getFormatedDate($patient->lastAppointment->appointments_day->date)) < strtotime(date('d.m.Y') . ' -' . self::MAX_YEARS . ' years')) {
            return false;
        }
        return true;
    }
}