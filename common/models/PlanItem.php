<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "plan_item".
 *
 * @property int $id
 * @property int $plan_id
 * @property int $operation_id
 * @property int $region_id
 * @property string $comment
 * @property int $price_from
 * @property int $price_to
 */
class PlanItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plan_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['plan_id', 'operation_id', 'region_id', 'price_from', 'price_to'], 'integer'],
            [['comment'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'plan_id' => 'Plan ID',
            'operation_id' => 'Operation ID',
            'region_id' => 'Region ID',
            'comment' => 'Comment',
            'price_from' => 'Стоимость от',
            'price_to' => 'Стоимость до',
        ];
    }
}
