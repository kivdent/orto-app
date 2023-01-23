<?php

namespace common\modules\schedule\models;

use common\modules\schedule\models\CallList;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * CallListSearch represents the model behind the search form of `\common\modules\schedule\models\CallList`.
 */
class CallListSearch extends CallList
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee_id'], 'integer'],
            [['title', 'Description', 'created_at', 'updated_at', 'type', 'status'], 'safe'],
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
    public function search($params,$authors='all')
    {
        if ($authors=='all'){
            $query = CallList::find()->orderBy('status');
        }else{
            $query = CallList::find()->orderBy('status')->where(['employee_id'=>$authors]);
        }
       

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
            ->andFilterWhere(['like', 'Description', $this->Description])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
