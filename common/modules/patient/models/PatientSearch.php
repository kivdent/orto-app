<?php

namespace common\modules\patient\models;

use common\modules\invoice\models\SchemeOrthodontics;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\patient\models\Patient;
use yii\db\ActiveQuery;

/**
 * PatientSearch represents the model behind the search form of `common\modules\patient\models\Patient`.
 */
class PatientSearch extends Patient
{
    const TYPE_ALL = 'all';
    const TYPE_ORTHODONTICS = 'orthodontics';


    public $prepaymentAmount;
    public $type = self::TYPE_ALL;
    public $fullName;
    public $orthodonticsPayPerMonth;

    public function gatPrepaymentAmount()
    {
        return ($this->prepayment) ? $this->prepayment->avans : '0';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'number'],
            [['orthodonticsPayPerMonth', 'fullName', 'surname', 'name', 'otch', 'dr', 'sex', 'adres', 'MestRab', 'prof', 'email', 'DTel', 'RTel', 'MTel', 'FLech', 'Prim', 'prepaymentAmount'], 'safe'],
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
            case self::TYPE_ORTHODONTICS:
                $query->select('`klinikpat`.*,')
                    ->leftJoin('`orto_sh`', '`orto_sh`.`pat` = `klinikpat`.`id`')
                    ->where('`orto_sh`.`summ`>`orto_sh`.`vnes`');
                break;
        }
        return $query;

    }
}
