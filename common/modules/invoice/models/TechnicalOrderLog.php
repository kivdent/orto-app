<?php

namespace common\modules\invoice\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 *
 * @property-read string $statusName
 */
class TechnicalOrderLog extends \common\models\TechnicalOrderLog
{



    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'technical_order_id' => 'Technical Order ID',
            'employee_id' => 'Сотрудник',
            'created_at' => 'Дата',
            'status' => 'статус',
            'comment' => 'Комментарий',
            'items' => 'Позиции',
        ];
    }

    public function getStatusName(): string
    {
        return TechnicalOrder::getStatusNameList()[$this->status];
    }

}