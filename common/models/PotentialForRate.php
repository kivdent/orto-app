<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "potential_for_rate".
 *
 * @property int $id
 * @property string $rate_name
 * @property double $rate_hours
 * @property int $hour_price
 * @property int $load_goal_percent
 * @property int $financial_period_id
 */
class PotentialForRate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'potential_for_rate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rate_hours'], 'number'],
            [['hour_price', 'load_goal_percent', 'financial_period_id'], 'integer'],
            [['rate_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rate_name' => 'Rate Name',
            'rate_hours' => 'Rate Hours',
            'hour_price' => 'Hour Price',
            'load_goal_percent' => 'Load Goal Percent',
            'financial_period_id' => 'Financial Period ID',
        ];
    }
}
