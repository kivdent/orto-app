<?php

namespace common\modules\api\models;

use common\modules\userInterface\models\UserInterface;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class OperationPricelistItemsComplianceSearch extends OperationPricelistItemsCompliance
{
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = OperationPricelistItemsCompliance::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
        $this->load($params, '');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'operation_id' => $this->operation_id,
            'pricelist_item_id' => $this->pricelist_item_id
        ]);
        return $dataProvider;
    }
}