<?php

namespace common\modules\api\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class DiagnosisSearch extends Diagnosis
{
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Diagnosis::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
//        $query->andFilterWhere([
////            'id' => $this->id,
////            'dr' => $this->dr,
////            'Skidka' => $this->Skidka,
//        ]);

//        $query->andFilterWhere(['like', 'surname', $this->surname . '%', false])
//            ->andFilterWhere(['like', 'name', $this->name])
//            ->andFilterWhere(['like', 'otch', $this->otch])
//            ->andFilterWhere(['like', 'sex', $this->sex])
//            ->andFilterWhere(['like', 'adres', $this->adres])
//            ->andFilterWhere(['like', 'MestRab', $this->MestRab])
//            ->andFilterWhere(['like', 'prof', $this->prof])
//            ->andFilterWhere(['like', 'email', $this->email])
//            ->andFilterWhere(['like', 'DTel', $this->DTel])
//            ->andFilterWhere(['like', 'RTel', $this->RTel])
//            ->andFilterWhere(['like', 'MTel', $this->MTel])
//            ->andFilterWhere(['like', 'FLech', $this->FLech])
//            ->andFilterWhere(['like', 'Prim', $this->Prim]);
//        if ($this->fullName) {
//            $query->andFilterWhere(['like', 'surname', $this->fullName . '%', false]);
//        }

        return $dataProvider;
    }
}