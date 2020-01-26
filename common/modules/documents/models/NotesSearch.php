<?php

namespace common\modules\documents\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\documents\models\Notes;

/**
 * NotesSearch represents the model behind the search form of `\common\models\Notes`.
 */
class NotesSearch extends Notes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'author_id', 'patient_id'], 'integer'],
            [['title', 'type', 'text', 'created_at', 'updated_at'], 'safe'],
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
        $query = Notes::find()
            ->where('patient_id=:patient_id',[':patient_id' =>$patient_id ])
            ->orderBy(['created_at'=>SORT_DESC]);

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'author_id' => $this->author_id,
            'patient_id' => $this->patient_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
