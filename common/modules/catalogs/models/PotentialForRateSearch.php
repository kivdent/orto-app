<?php

namespace common\modules\catalogs\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\catalogs\models\PotentialForRate;

/**
 * PotentialForRateSearch represents the model behind the search form of `\common\modules\catalogs\models\PotentialForRate`.
 */
class PotentialForRateSearch extends PotentialForRate
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'hour_price', 'load_goal_percent', 'financial_period_id'], 'integer'],
            [['rate_name'], 'safe'],
            [['rate_hours'], 'number'],
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
        $query = PotentialForRate::find();

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
            'rate_hours' => $this->rate_hours,
            'hour_price' => $this->hour_price,
            'load_goal_percent' => $this->load_goal_percent,
            'financial_period_id' => $this->financial_period_id,
        ]);

        $query->andFilterWhere(['like', 'rate_name', $this->rate_name]);

        return $dataProvider;
    }
}
