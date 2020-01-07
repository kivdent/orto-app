<?php

namespace common\modules\patient\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\patient\models\MedicalRecords;

/**
 * MedicalRecordsSearch represents the model behind the search form of `\common\modules\patient\models\MedicalRecords`.
 */
class MedicalRecordsSearch extends MedicalRecords
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'region_id', 'diagnosis_id', 'invoice_id','employe_id'], 'integer'],
            [['complaints', 'anamnesis', 'objectively', 'recommendations', 'prescriptions','therapy'], 'safe'],
            [['date'],'date']
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
        $query = MedicalRecords::find()
            ->where('patient_id=:patient_id',[':patient_id' =>$patient_id ])
            ->orderBy(['date'=>SORT_DESC]);

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
            'employe_id' => $this->employe_id,
            'region_id' => $this->region_id,
            'diagnosis_id' => $this->diagnosis_id,
            'invoice_id' => $this->invoice_id,
        ]);

        $query->andFilterWhere(['like', 'complaints', $this->complaints])
            ->andFilterWhere(['like', 'anamnesis', $this->anamnesis])
            ->andFilterWhere(['like', 'objectively', $this->objectively])
            ->andFilterWhere(['like', 'recommendations', $this->recommendations])
            ->andFilterWhere(['like', 'prescriptions', $this->prescriptions]);

        return $dataProvider;
    }
}
