<?php

namespace common\modules\patient\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\patient\models\Patient;

/**
 * PatientSearch represents the model behind the search form of `common\modules\patient\models\Patient`.
 */
class PatientSearch extends Patient
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'number'],
            [['surname', 'name', 'otch', 'dr', 'sex', 'adres', 'MestRab', 'prof', 'email', 'DTel', 'RTel', 'MTel', 'FLech', 'Prim'], 'safe'],
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

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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

        $query->andFilterWhere(['like', 'surname', $this->surname])
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

        return $dataProvider;
    }
}
