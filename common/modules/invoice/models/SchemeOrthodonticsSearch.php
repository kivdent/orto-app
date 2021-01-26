<?php

namespace common\modules\invoice\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\invoice\models\SchemeOrthodontics;

/**
 * SchemeOrthodonticsSearch represents the model behind the search form of `\common\modules\invoice\models\SchemeOrthodontics`.
 */
class SchemeOrthodonticsSearch extends SchemeOrthodontics
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pat', 'sotr', 'per_lech', 'summ', 'summ_month', 'vnes', 'full', 'last_pay_month'], 'integer'],
            [['date'], 'safe'],
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
        $query = SchemeOrthodontics::find();

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
            'pat' => $this->pat,
            'sotr' => $this->sotr,
            'date' => $this->date,
            'per_lech' => $this->per_lech,
            'summ' => $this->summ,
            'summ_month' => $this->summ_month,
            'vnes' => $this->vnes,
            'full' => $this->full,
            'last_pay_month' => $this->last_pay_month,
        ]);

        return $dataProvider;
    }
}
