<?php

namespace common\modules\documents\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Documents extends \common\models\Documents
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hash' => 'Хеш',
            'signed' => 'Попсано',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
            'employee_id' => 'Сотрудник',
        ];
    }
}