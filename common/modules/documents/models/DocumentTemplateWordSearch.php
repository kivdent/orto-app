<?php

namespace common\modules\documents\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\documents\models\DocumentTemplateWord;

/**
 * DocumentTemplateWordSearch represents the model behind the search form of `\common\modules\documents\models\DocumentTemplateWord`.
 */
class DocumentTemplateWordSearch extends DocumentTemplateWord
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee_id'], 'integer'],
            [['title', 'created_at', 'updated_at', 'file_name', 'description', 'variables'], 'safe'],
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
        $query = DocumentTemplateWord::find();

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
            'employee_id' => $this->employee_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'file_name', $this->file_name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'variables', $this->variables]);

        return $dataProvider;
    }
}
