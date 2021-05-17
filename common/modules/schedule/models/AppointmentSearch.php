<?php

namespace common\modules\schedule\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\schedule\models\Appointment;

/**
 * AppointmentSearch represents the model behind the search form of `\common\modules\schedule\models\Appointment`.
 */
class AppointmentSearch extends Appointment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id', 'Perv', 'PatID', 'dayPR', 'SoderzhNaz', 'RezObzv', 'Yavka'], 'integer'],
            [['NachNaz', 'OkonchNaz', 'NachPr', 'OkonchPr'], 'safe'],
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
        $query = Appointment::find();

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
            'Id' => $this->Id,
            'Perv' => $this->Perv,
            'PatID' => $this->PatID,
            'dayPR' => $this->dayPR,
            'NachNaz' => $this->NachNaz,
            'OkonchNaz' => $this->OkonchNaz,
            'SoderzhNaz' => $this->SoderzhNaz,
            'RezObzv' => $this->RezObzv,
            'Yavka' => $this->Yavka,
            'NachPr' => $this->NachPr,
            'OkonchPr' => $this->OkonchPr,
        ]);

        return $dataProvider;
    }
}
