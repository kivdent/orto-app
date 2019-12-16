<?php


namespace common\modules\patient\models\forms;


use common\modules\patient\models\PlanItem;

class PlanItemForm extends PlanItem
{
    public function attributeLabels()
    {
        return [

            'id' => 'ID',
            'plan_id' => 'План лечения',
            'operation_id' => 'Рекомендация',
            'region_id' => 'Область',
            'comment' => 'Комментарий',
        ];
    }
}