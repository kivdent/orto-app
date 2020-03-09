<?php


namespace common\modules\patient\models;


class PlanItem extends \common\models\PlanItem
{


    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    public function getOperation()
    {
        return $this->hasOne(Operation::className(), ['id' => 'operation_id']);
    }

    public function attributeLabels()
    {
        return [

            'id' => 'ID',
            'plan_id' => 'План лечения',
            'operation_id' => 'Рекомендация',
            'region_id' => 'Область',
            'comment' => 'Комментарий',
            'price_from' => 'Стоимость от',
            'price_to' => 'Стоимость до',
        ];
    }

    public function getRegionTitle()
    {
        return $this->region->title;
    }

    public function fromComment()
    {
        return $this->operation_id === 1;
    }

    public function getOperationTitle()
    {
        $title = '';
        $title = $this->fromComment() ? $this->comment : $this->operation->title;

        return $title;
    }
    public function getCommentText(){
        return $this->fromComment() ? '' :$this->comment ;
    }

}