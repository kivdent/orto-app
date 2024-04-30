<?php


namespace common\modules\invoice\models;


use common\modules\employee\models\Employee;
use common\modules\userInterface\models\UserInterface;
use yii\data\ActiveDataProvider;
use common\modules\invoice\models\Invoice;

/**
 * Class InvoiceSearch
 * @package common\modules\invoice\models
 *
 * @property string $searchType;
 *
 * @var $query Invoice
 */
class InvoiceSearch extends Invoice
{


    public $searchType = Invoice::SEARCH_TYPE_ALL;

    public $amount_residual;
    public $patientFullName;
    public $employeeFullName;
    public $doctorFullNameForTechnicalOrder;
    public $date;
    public $patient_card_id;
    public $completed;
    public $status;

    public static function getEmployeeListWithInvoice()
    {
        $list = [];
        $emplyees = Employee::find()->orderBy('surname')->all();
        $invoices = Invoice::find()->select('doctor_id')->groupBy('doctor_id')->asArray()->all();
        foreach ($emplyees as $employee) {
            if (array_search($employee->id, array_column($invoices, 'doctor_id'))) {
                $list[$employee->id] = $employee->getFullName();
            }
        }
//        echo "<pre>" . var_dump($invoices) . "</pre>";
//        die();
        return $list;
    }

    private function setDefaultQuery()
    {
        $query = Invoice::find();
        switch ($this->searchType) {
            case self::SEARCH_TYPE_DEBT:
                $query->where('amount_payable>paid')->andWhere("type<>'" . Invoice::TYPE_TECHNICAL_ORDER . "'")->orderBy('created_at DESC');
                break;
            case self::SEARCH_TYPE_FOR_PATIENT_CARD:
                $query->where(['patient_id' => $this->patient_card_id])->orderBy('created_at DESC');
                break;
            case self::SEARCH_TYPE_EMPLOYEE_DEBT:
                $query->where('amount_payable>paid')
                    ->andWhere(['doctor_id' => \Yii::$app->user->identity->employe_id])
                    ->orderBy('created_at DESC');
                break;
            case self::SEARCH_TYPE_TECHNICAL_ORDER:
                $query->where(['`invoice`.`type`' => Invoice::TYPE_TECHNICAL_ORDER])
                    ->andWhere(['patient_id' => $this->patient_card_id])
                    ->andWhere(['type' => Invoice::TYPE_TECHNICAL_ORDER])
                    ->leftJoin('technical_order', ['invoice.id' => 'technical_order.technical_order_invoice_id'])
                    ->orderBy('`technical_order`.`id` DESC');
                break;
            case self::SEARCH_TYPE_TECHNICAL_ORDER_ALL:
//                $query->where(['type' => Invoice::TYPE_TECHNICAL_ORDER])
//                    ->leftJoin('technical_order', ['invoice.id' => 'technical_order.technical_order_invoice_id'])
//                    ->orderBy('technical_order.id DESC');
                $query->where(['invoice.type' => Invoice::TYPE_TECHNICAL_ORDER])
                    ->orderBy('created_at DESC');
                break;
            case self::SEARCH_TYPE_TECHNICAL_ORDER_TECHNICIAN:
                $query->where(['invoice.type' => Invoice::TYPE_TECHNICAL_ORDER])
                    ->andWhere(['invoice.doctor_id' => \Yii::$app->user->identity->employe_id])
                    ->orderBy('created_at DESC');
                break;
            case self::SEARCH_TYPE_TECHNICAL_ORDER_DOCTOR:
                $query->where(['invoice.type' => Invoice::TYPE_TECHNICAL_ORDER])
                    ->leftJoin('technical_order as to', 'invoice.id = to.technical_order_invoice_id')
                    ->leftJoin('invoice as di', 'to.invoice_id = di.id')
                    ->andWhere(['di.doctor_id' => \Yii::$app->user->identity->employe_id])
                    ->orderBy('created_at DESC');
                break;
            case self::SEARCH_TYPE_DOCTOR_INVOICES:
                $query->where(['patient_id' => $this->patient_card_id])
                    ->andWhere(['<>', 'type', Invoice::TYPE_TECHNICAL_ORDER])
                    ->orderBy('created_at DESC');

                break;
            case self::SEARCH_TYPE_ALL:
                $query
                    ->orderBy('created_at DESC');
                break;
        }
        return $query;
    }

    public function rules()
    {
        return [
            [['doctor_id', 'patient_id', 'amount', 'amount_payable', 'paid', 'discount_id', 'appointment_id'], 'safe'],
            [['created_at', 'updated_at'], 'safe'],
            [['type'], 'safe'],
            [['patientFullName', 'employeeFullName', 'doctorFullNameForTechnicalOrder', 'completed', 'status'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = $this->setDefaultQuery();

        // add conditions that should always apply here
        // $query = Invoice::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'patientFullName' => [
                    'asc' => ['klinikpat.surname' => SORT_ASC],
                    'desc' => ['klinikpat.surname' => SORT_DESC],
                    'label' => 'Пациент',
                ],
                'date' => [
                    'asc' => ['created_at' => SORT_ASC],
                    'desc' => ['created_at' => SORT_DESC],
                    'label' => 'Дата',
                ],
                'status' => [
                    'asc' => ['technical_order.completed' => SORT_ASC],
                    'desc' => ['technical_order.completed' => SORT_DESC],
                    'label' => 'Статус',
                ],
            ]
        ]);

        $this->load($params);

        if (!($this->load($params) && $this->validate())) {
            $query->joinWith('patient');
            return $dataProvider;
        }
        $query->joinWith(['patient' => function ($q) {
            $q->where('klinikpat.surname LIKE "' . $this->patientFullName . '%"');
        }]);
        if ($this->employeeFullName) {
            $query->joinWith(['employee' => function ($q) {
                $q->where('sotr.id = ' . $this->employeeFullName);
            }]);
        }
        if (($this->completed === '0') or ($this->completed === '1')) {

            $query->joinWith(['technicalOrder' => function ($q) {
                $q->where(['technical_order.completed' => $this->completed]);
            }]);
        }

        if (isset($this->status) && (!empty($this->status))) {

            $query->joinWith(['technicalOrder' => function ($q) {
                $q->where(['technical_order.completed' => $this->status]);
            }]);

        }

        if ($this->doctorFullNameForTechnicalOrder) {
            $query->joinWith(['doctorInvoiceForTechnicalOrder di' => function ($q) {
                $q->where('di.doctor_id=' . $this->doctorFullNameForTechnicalOrder);
            }]);
        }
//        if ($this->doctorFullNameForTechnicalOrder) {
//            $query->leftJoin('technical_order', ['`technical_order`.`technical_order_invoice_id`'=>'`invoice`.`id`'])
//            ->leftJoin('invoice to_invoice');
//        }

        // grid filtering conditions
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'dr' => $this->dr,
//            'Skidka' => $this->Skidka,
//        ]);
//
//        $query->andFilterWhere(['like', 'surname', $this->surname.'%',false])
//            ->andFilterWhere(['like', 'name', $this->name])
//            ->andFilterWhere(['like', 'otch', $this->otch])
//            ->andFilterWhere(['like', 'sex', $this->sex])
//            ->andFilterWhere(['like', 'adres', $this->adres])
//            ->andFilterWhere(['like', 'MestRab', $this->MestRab])
//            ->andFilterWhere(['like', 'prof', $this->prof])
//            ->andFilterWhere(['like', 'email', $this->email])
//            ->andFilterWhere(['like', 'DTel', $this->DTel])
//            ->andFilterWhere(['like', 'RTel', $this->RTel])
//            ->andFilterWhere(['like', 'MTel', $this->MTel])
//            ->andFilterWhere(['like', 'FLech', $this->FLech])
//            ->andFilterWhere(['like', 'Prim', $this->Prim]);
        return $dataProvider;
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['completed'] = 'Статус';
        UserInterface::getVar($labels);
        return $labels;
    }
}