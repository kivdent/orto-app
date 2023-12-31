<?php

namespace common\modules\employee\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\employee\models\Employee;

/**
 * EmployeeSearch represents the model behind the search form of `common\modules\employee\models\Employee`.
 */
class EmployeeSearch extends Employee
{
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'dolzh'], 'integer'],
            [['surname', 'name', 'otch', 'dr', 'dtel', 'mtel', 'adres','position'], 'safe'],
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
        $query = Employee::find();

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
            'dolzh' => $this->dolzh,
        ]);

        $query->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'otch', $this->otch])
            ->andFilterWhere(['like', 'dtel', $this->dtel])
            ->andFilterWhere(['like', 'mtel', $this->mtel])
            ->andFilterWhere(['like', 'adres', $this->adres]);

        return $dataProvider;
    }
}
