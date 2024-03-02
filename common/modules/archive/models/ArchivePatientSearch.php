<?php

namespace common\modules\archive\models;

use common\modules\clinic\models\Settings;
use common\modules\invoice\models\SchemeOrthodontics;
use common\modules\userInterface\models\UserInterface;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\patient\models\Patient;
use yii\db\ActiveQuery;

/**
 * PatientSearch represents the model behind the search form of `common\modules\patient\models\Patient`.
 */
class ArchivePatientSearch extends Patient
{
    const TYPE_OLD = 'old';
    const TYPE_EMPTY = 'empty';


    public $prepaymentAmount;
    public $type = self::TYPE_OLD;
    public $fullName;
    public $orthodonticsPayPerMonth;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'number'],
            [['fullName', 'surname', 'name', 'otch', 'dr', 'sex', 'adres', 'MestRab', 'prof', 'email', 'DTel', 'RTel', 'MTel', 'FLech', 'Prim', 'prepaymentAmount'], 'safe'],
            [['Skidka'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Patient::find();
        $query = $this->modifyQueryByType($query);
        // add conditions that should always apply here
        $query->leftJoin('archival_patient_records', 'archival_patient_records.patient_id=klinikpat.id')
            ->andWhere('archival_patient_records.patient_id IS NULL');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'fullName' => [
                    'asc' => ['surname' => SORT_ASC, 'name' => SORT_ASC],
                    'desc' => ['surname' => SORT_DESC, 'name' => SORT_DESC],
                    'label' => 'Имя',
                    'default' => SORT_ASC
                ],

            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'dr' => $this->dr,
            'Skidka' => $this->Skidka,
        ]);

        $query->andFilterWhere(['like', 'surname', $this->surname . '%', false])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'otch', $this->otch])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'adres', $this->adres])
            ->andFilterWhere(['like', 'MestRab', $this->MestRab])
            ->andFilterWhere(['like', 'prof', $this->prof])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'DTel', $this->DTel])
            ->andFilterWhere(['like', 'RTel', $this->RTel])
            ->andFilterWhere(['like', 'MTel', $this->MTel])
            ->andFilterWhere(['like', 'FLech', $this->FLech])
            ->andFilterWhere(['like', 'Prim', $this->Prim]);
        if ($this->fullName) {
            $query->andFilterWhere(['like', 'surname', $this->fullName . '%', false]);
        }
        return $dataProvider;
    }

    private function modifyQueryByType(ActiveQuery $query)
    {
        switch ($this->type) {

            case self::TYPE_OLD:
                $date = (date('Y') - Settings::getCardArchivePeriod()) . '-' . date('m') . '-1';
                $query->select('klinikpat.*, invoice.patient_id, max(invoice.created_at) as last_invoice_date')
                    ->from('invoice')
                    ->leftJoin('klinikpat', 'klinikpat.id=invoice.patient_id')
                    ->groupBy('patient_id')
                    ->having("max(invoice.created_at)<'" . $date . "'");
                break;

            case self::TYPE_EMPTY:
                $query->leftJoin('invoice', 'invoice.patient_id=klinikpat.id')
                    ->where('invoice.patient_id IS NULL');
                break;
        }
        return $query;
    }

    public static function getEmptyCount()//Не работает
    {
        $query = Patient::find()->select('count(patient_id) as cards_count,max(created_at)')
            ->from('invoice')
            ->leftJoin('klinikpat', 'klinikpat.id=invoice.patient_id')
            ->groupBy('patient_id')
            ->having("max(created_at)<'2015-01-02'")
            ->one();
        UserInterface::getVar($query->cards_count);
        return $query->cards_count;
    }

    public static function getOldCount()
    {

    }
}
