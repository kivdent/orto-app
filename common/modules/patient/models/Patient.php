<?php

namespace common\modules\patient\models;

use common\modules\cash\models\Prepayment;
use common\modules\catalogs\models\Agreement;
use common\modules\discounts\models\DiscountCard;
use common\modules\employee\models\Employee;
use common\modules\invoice\models\Invoice;
use common\modules\invoice\models\SchemeOrthodontics;
use common\modules\schedule\models\Appointment;
use common\modules\statistics\models\PatientStatistics;
use common\modules\userInterface\models\UserInterface;
use Yii;
use common\modules\userInterface\models\Addresses;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "klinikpat".
 *
 * @property double $id
 * @property string $surname+
 * @property string $name+
 * @property string $otch+
 * @property string $dr +
 * @property string $sex+
 * @property string $adres+
 * @property string $MestRab+
 * @property string $prof+
 * @property string $email+
 * @property string $DTel+
 * @property string $RTel+
 * @property string $MTel+
 * @property string $FLech+
 * @property string $card_type+
 * @property int $Skidka+
 * @property string $Prim+
 * @property string $address_id +
 * @property Agreement $agreement
 * @property Prepayment $prepayment
 * @property DiscountCard $fullDiscountCard
 * @property SchemeOrthodontics $schemeOrthodontics
 * @property string $fullName
 * @property integer $orthodonticsPayPerMonth
 * @property string $statusName
 * @property string $status
 * @property string $allSchemeOrthodontics
 * @property string $addressString
 * @property Appointment $lastAppointment
 * @property int $totalInvoiceSumm
 * @property int $totalAppointments
 * @property-read mixed $duplicate
 * @property-read mixed $address
 * @property-read string[] $sexList
 * @property-read string $prepaymentAmount
 * @property-read TreatmentPlan[] $treatmentPlans
 * @property-read int $treatmentPlansCount
 * @property-read int $totalRealAppointments
 * @property bool isInitial;
 * @property int $countDoctors
 */
class Patient extends \yii\db\ActiveRecord
{

    const SEX_MALE = 'Муж';
    const SEX_FEMALE = 'Жен';
    const SEX_NOT_SET = '';
    const DEFAULT_ID = 1; //TO_DO При установке создавать пациента с id=1 и id=0

    const STATUS_ARCHIVE_IN_ARCHIVE = 'in_archive';
    const STATUS_ARCHIVE_NOT_FOUND = 'not_found';
    const STATUS_ARCHIVE_IN_CARD_INDEX = 'in_card_index';
    const STATUS_ARCHIVE_IN_THE_OFFICE = 'in_the_office';
    const STATUS_ARCHIVE_REQUESTED_FROM_ARCHIVE = 'requested_from_archive';

    const PATIENT_TYPE_PATIENT = 'patient';
    const PATIENT_TYPE_SERVICE_RECORD = 'service_record';

    /**
     * @var mixed|null
     */


    public static function getListForWidget()
    {
        $list = self::find()->select(["id", "CONCAT(surname,' ',name,' ',otch)  as full_name"])->orderBy('surname')->asArray()->all();
        $list = ArrayHelper::map($list, 'id', 'full_name');
        return $list;
    }

    public function getPrepaymentAmount()
    {
        return ($this->prepayment) ? $this->prepayment->avans : '0';
    }

    public static function getStatusNameList()
    {
        return [
            self::STATUS_ARCHIVE_IN_ARCHIVE => 'В архиве',
            self::STATUS_ARCHIVE_NOT_FOUND => 'Карта не найдена',
            self::STATUS_ARCHIVE_IN_CARD_INDEX => 'В картотеке',
            self::STATUS_ARCHIVE_IN_THE_OFFICE => 'У врача',
            self::STATUS_ARCHIVE_REQUESTED_FROM_ARCHIVE => 'Запрошена из архива',];
    }

    public static function getTypesNameList()
    {
        return [
            self::PATIENT_TYPE_PATIENT => 'Пациент',
            self::PATIENT_TYPE_SERVICE_RECORD => 'Служебная запись',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'klinikpat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dr'], 'safe'],
            [['Skidka', 'address_id'], 'integer'],
            [['status'], 'string'],
            [['Prim'], 'string'],
            [['card_type'], 'string'],
            [['surname'], 'string', 'max' => 20],
            [['name', 'otch', 'MestRab', 'prof', 'DTel', 'RTel', 'MTel', 'FLech'], 'string', 'max' => 15],
            [['sex'], 'string', 'max' => 5],
            [['adres'], 'string', 'max' => 255],
            [['email'], 'email',],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Карта',
            'surname' => 'Фимилия',
            'name' => 'Имя',
            'otch' => 'Отчество',
            'dr' => 'Дата рождения',
            'sex' => 'Пол',
            'adres' => 'Адрес',
            'MestRab' => 'Место работы',
            'prof' => 'Профессия',
            'email' => 'Электронная почта',
            'DTel' => 'Домашний телефон',
            'RTel' => 'Рабочий телефон',
            'MTel' => 'Мобильный телефон',
            'FLech' => 'Форма лечения',
            'Skidka' => 'Скидка',
            'Prim' => 'Примечание',
            'fullName' => 'Имя',
            'orthodonticsPayPerMonth' => 'Оплата за месяц',
            'status' => 'Статус карты',
            'address_id' => 'Адрес',
            'card_type' => 'Тип карты'
        ];
    }

    public function afterFind()
    {

        $this->dr = Yii::$app->formatter->asDate($this->dr, 'php:d.m.Y');
    }

    public function beforeSave($insert)
    {

        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->dr = Yii::$app->formatter->asDate($this->dr, 'php:Y-m-d');
        return true;
    }

    public function getSex()
    {
        return $this->sex;
    }

    public function getSexList()
    {
        return [
            self::SEX_FEMALE => 'Женский',
            self::SEX_MALE => 'Мужской',
            self::SEX_NOT_SET => 'Не выбран',
        ];
    }

    public function getAddress()
    {
        return $this->hasOne(Addresses::class, ['id' => 'address_id']);
    }

    public function getAddressString()
    {
        if ($this->address !== null) {
            $address = $this->address->addressString;
        } else {
            $address = $this->adres;
        }
        return $address;
    }

    public function getFullName()
    {
        return $this->surname . " " . $this->name . " " . $this->otch;
    }

    public function getId()
    {
        return $this->id;
    }


    public function getAgreement()
    {
        return $this->hasOne(Agreement::className(), ['pat' => 'id']);
    }

    public function getPrepayment()
    {
        return $this->hasOne(Prepayment::className(), ['pat' => 'id']);
    }

    public function getFullDiscountCard()
    {
        return DiscountCard::find()->where(['type' => 3, 'pat' => $this->id]);
    }

    public function getSchemeOrthodontics()
    {
        return $this->hasOne(SchemeOrthodontics::className(), ['pat' => 'id'])->andWhere('vnes<>summ');
//        return SchemeOrthodontics::find()->where(['pat'=>$this->id])->andWhere('vnes<>summ')->one();
    }

    public function getAllSchemeOrthodontics()
    {
        $this->hasMany(SchemeOrthodontics::class, ['pat' => 'id']);
    }

    public function getOrthodonticsPayPerMonth()
    {
        return ($this->schemeOrthodontics) ? $this->schemeOrthodontics->summ_month : null;
    }

    public function getDuplicate()
    {
        return Patient::find()
            ->where([
                'surname' => $this->surname,
                'name' => $this->name,
                'otch' => $this->otch])
            ->andWhere(['<>', 'id', $this->id])
            ->one();
    }

    public function hasAddress()
    {

        return $this->address_id === null ? false : true;
    }

    public function getStatusName()
    {
        return self::getStatusNameList()[$this->status];
    }

    public function canCreateSchemeOrthodontic()
    {
        return !(bool)$this->schemeOrthodontics or $this->schemeOrthodontics->isCompleted();
    }

    public function hasSchemeOrthodonticWithDoctor($vrachID)
    {
        return (bool)$this->schemeOrthodontics && $this->schemeOrthodontics->sotr == $vrachID;
    }

    public function getLastAppointment()
    {
        return Appointment::find()
            ->where(['PatID' => $this->id])
            ->leftJoin('daypr', 'daypr.id=nazn.dayPR')
            ->orderBy('daypr.date DESC')
            ->one();
    }

    public function getTotalAppointments()
    {
        return Appointment::find()
            ->select('PatID')
            ->where(['PatID' => $this->id])
            ->count('PatID');
    }

    /**
     * @return int
     */
    public function getTotalRealAppointments()
    {
        return Appointment::find()
            ->select('PatID')
            ->leftJoin('daypr', ['daypr.id' => 'nazn.dayPR'])
            ->where([
                'PatID' => $this->id,
                'status' => Appointment::STATUS_ACTIVE,
            ])
            ->andWhere(['>', 'daypr.date', date('Y-m-d')])
            ->count('PatID');
    }

    public function getTotalInvoiceSumm()
    {
        return Invoice::find()
            ->where(['patient_id' => $this->id])
            ->sum('paid');
    }

    /**
     * @return bool
     */
    public function getIsInitial(): bool
    {
        $initial = true;
        $appointment = Appointment::find()
            ->where(['PatID' => $this->id])
            ->andWhere(['<>', 'NachPr', '00:00:00'])
            ->all();
        if ($appointment !== null) $initial = false;
        return $initial;
    }

    public function getTreatmentPlans(): \yii\db\ActiveQuery
    {
        return $this->hasMany(TreatmentPlan::class, ['patient' => 'id']);
    }

    public function getTreatmentPlansCount(): int
    {
        return count($this->treatmentPlans);
    }

    /**
     * @return int
     */
    public function getCountDoctors(): int
    {
        return Invoice::find()
            ->select('doctor_id')
            ->where(['patient_id' => $this->id])
            ->andWhere(['in', 'type', [Invoice::TYPE_ORTHODONTICS, Invoice::TYPE_MANIPULATIONS]])
            ->groupBy('doctor_id')
            ->count('doctor_id');
    }

    /**
     * @param string $IDS
     * @return Invoice
     */
    public function lastDateManipulationInvoice(string $IDS)
    {
        $invoice = Invoice::find()
            ->leftJoin('invoice_items', 'invoice_items.invoice_id=invoice.id')
            ->leftJoin('prices', 'prices.id=invoice_items.prices_id')
            ->where([
                'prices.pricelist_items_id' => PatientStatistics::getPriceListItemsIds()[$IDS],
                'invoice.patient_id' => $this->id
            ])
            ->orderBy('invoice.created_at DESC')
            ->one();
        return $invoice;
    }

    /**
     * @return string
     */
    public function getOrthodonticsFirstDateForPatient()
    {
        $IDS = PatientStatistics::getPriceListItemsIds()[PatientStatistics::ORTHODONTICS_IDS];
        $date = $this->getManipulationFirstDate($IDS)->created_at ?? 'Нет';
        return $date;
    }

    /**
     * @param array $IDS
     * @return Invoice
     */
    public function getManipulationFirstDate(array $IDS)
    {

        $invoice = Invoice::find()
            ->select(['invoice.patient_id', 'min(invoice.created_at) as created_at'])
            ->leftJoin('invoice_items', 'invoice_items.invoice_id=invoice.id')
            ->leftJoin('prices', 'prices.id=invoice_items.prices_id')
            ->leftJoin('pricelist_items', 'pricelist_items.id=prices.pricelist_items_id')
            ->where(['pricelist_items.id' => $IDS, 'invoice.patient_id' => $this->id])
            ->groupBy('invoice.patient_id')
            ->one();
        return $invoice;
    }

    /**
     * @return string
     */
    public function getFirstOrthodonticsConsultation(): string
    {

        $IDS = PatientStatistics::getConsultationPricelisitemsIds();
        $invoice = Invoice::find()
            ->select(['invoice.patient_id', 'min(invoice.created_at) as created_at'])
            ->leftJoin('invoice_items', 'invoice_items.invoice_id=invoice.id')
            ->leftJoin('prices', 'prices.id=invoice_items.prices_id')
            ->leftJoin('pricelist_items', 'pricelist_items.id=prices.pricelist_items_id')
            ->where(
                [
                    'pricelist_items.id' => $IDS,
                    'invoice.patient_id' => $this->id,
                    'invoice.doctor_id' => array_keys(Employee::getOrthodontsList())
                ])
            ->groupBy('invoice.patient_id')
            ->one();
        $date = $invoice->created_at ?? 'Не проводилась';

        return $date;
    }
}