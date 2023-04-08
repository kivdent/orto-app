<?php

namespace common\modules\schedule\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\schedule\models\IncomingCalls;

/**
 * IncomingCallsSearch represents the model behind the search form of `common\modules\schedule\models\IncomingCalls`.
 */
class IncomingCallsSearch extends IncomingCalls
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'doctor_id', 'employee_id', 'primary_patient', 'by_recommendation', 'rejection_reasons_id'], 'integer'],
            [['created_at', 'updated_at', 'call_target', 'call_result'], 'safe'],
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
        $query = IncomingCalls::find()->orderBy('created_at DESC');

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
            'doctor_id' => $this->doctor_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'employee_id' => $this->employee_id,
            'primary_patient' => $this->primary_patient,
            'by_recommendation' => $this->by_recommendation,
            'rejection_reasons_id' => $this->rejection_reasons_id,
        ]);

        $query->andFilterWhere(['like', 'call_target', $this->call_target])
            ->andFilterWhere(['like', 'call_result', $this->call_result]);

        return $dataProvider;
    }
}
