<?php

namespace common\modules\patient\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\patient\models\TreatmentPlan;

/**
 * SearchTreatmentPlan represents the model behind the search form of `common\modules\patient\models\TreatmentPlan`.
 */
class SearchTreatmentPlan extends TreatmentPlan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'author', 'patient', 'deleted'], 'integer'],
            [['created_at', 'updated_at', 'comments'], 'safe'],
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
    public function search($params,$patient_id)
    {
        $query = TreatmentPlan::find()->where('patient=:patient_id',[':patient_id' =>$patient_id ])->andWhere('deleted=0');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]]
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'author' => $this->author,
            'patient' => $this->patient,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'comments', $this->comments]);

        return $dataProvider;
    }
}
