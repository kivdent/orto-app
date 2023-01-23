<?php

namespace common\modules\schedule\models;

use common\modules\schedule\models\CallListTasks;

use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * CallListTaskSearch represents the model behind the search form of `\common\modules\schedule\models\CallListTasks`.
 */
class CallListTaskSearch extends CallListTasks
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'patient_id', 'doctor_id', 'employee_id', 'call_list_id'], 'integer'],
            [['appointment_content', 'result', 'created_at', 'updated_at', 'note'], 'safe'],
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
    public function search($params, $callListId, $authors = 'all')
    {
        $query = CallListTasks::find()->where(['call_list_id' => $callListId])->orderBy('status');


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
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->doctor_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'employee_id' => $this->employee_id,
            'call_list_id' => $this->call_list_id,
        ]);

        $query->andFilterWhere(['like', 'appointment_content', $this->appointment_content])
            ->andFilterWhere(['like', 'result', $this->result])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
