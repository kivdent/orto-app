<?php

namespace common\modules\reports\models;

use common\modules\patient\models\Patient;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class PatientSearch extends \common\modules\patient\models\PatientSearch
{
    const TYPE_TREATMENT_PLAN = 'TREATMENT_PLAN';

    /**
     * @var FinancialPeriods
     */
    public $financialPeriod;
    public $treatmentPlans;
    public $treatmentPlansCount;

    public function search($params)
    {
        $query = Patient::find();
        $query = $this->modifyQueryByType($query);
        // add conditions that should always apply here

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
    public function rules()
    {
        return [
            [['id'], 'number'],
            [['$treatmentPlansCount','treatmentPlans','orthodonticsPayPerMonth', 'fullName', 'surname', 'name', 'otch', 'dr', 'sex', 'adres', 'MestRab', 'prof', 'email', 'DTel', 'RTel', 'MTel', 'FLech', 'Prim', 'prepaymentAmount'], 'safe'],
            [['Skidka'], 'integer'],
        ];
    }
    private function modifyQueryByType(ActiveQuery $query)
    {
        switch ($this->type) {

            case self::TYPE_ORTHODONTICS:
                $query->select('`klinikpat`.*,')
                    ->leftJoin('`orto_sh`', '`orto_sh`.`pat` = `klinikpat`.`id`')
                    ->where('`orto_sh`.`summ`>`orto_sh`.`vnes`');
                break;

            case self::TYPE_RECALL_RECORDER:
                $query->where("DATE_FORMAT(`klinikpat`.`dr`, '%m' )=" . date('m'));
                break;

            case self::TYPE_BIRTHDAY:
                $query->where("DATE_FORMAT(`klinikpat`.`dr`, '%m' )=" . date('m'));
//                $query->andWhere("klinikpat.status<>'".Patient::STATUS_ARCHIVE_IN_ARCHIVE."'");
                break;
            case self::TYPE_TREATMENT_PLAN:
                $query->select('`klinikpat`.*,')
                    ->leftJoin('invoice', 'invoice.patient_id = `klinikpat`.`id`')
                    ->where('invoice.created_at>="' . $this->financialPeriod->nach.'"')
                    ->groupBy("`klinikpat`.`id`")
                    ->andWhere('invoice.created_at<="' . $this->financialPeriod->okonch.'"');
                break;

        }
        return $query;
    }

}