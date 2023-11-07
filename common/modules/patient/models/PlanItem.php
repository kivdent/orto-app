<?php


namespace common\modules\patient\models;

/**
 * @property-read Operation $operation
 * @property-read string $commentText
 * @property-read Region $region
 * @property-read string $regionTitle
 * @property-read string $operationTitle
 * @property int $price_actual
 */
class PlanItem extends \common\models\PlanItem
{


    /**
     * @var mixed|null
     */

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
            'duration_from' => 'Срок от ',
            'duration_to' => 'Срок до'
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

    public function getCommentText()
    {
        return $this->fromComment() ? '' : $this->comment;
    }

    public function getPrice_actual()
    {
        $price = 0;

        if ($this->setPrice_actual() !== null) {
            $price = $this->setPrice_actual();
        } elseif ($this->price_to !== null) {
            $price = $this->price_to;
        } elseif ($this->price_from !== null) {
            $price = $this->price_from;
        }

        return $price;
    }

    private function setPrice_actual()
    {
        return $this->operation->actualPrice;
    }

    public function rules()
    {
        return [
            [['plan_id', 'operation_id', 'region_id', 'price_from', 'price_to', 'duration_from', 'duration_to'], 'integer'],
            [['operation_id', 'region_id'], 'required'],
            [['comment'], 'string'],
        ];
    }
}