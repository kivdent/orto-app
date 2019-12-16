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
            [['plan_id', 'operation_id', 'region_id'], 'integer'],
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
            'plan_id' => 'План лечения',
            'operation_id' => 'Работа',
            'region_id' => 'Область',
            'comment' => 'Комментарий',
        ];
    }
}
