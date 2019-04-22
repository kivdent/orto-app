<?php

namespace common\modules\catalogs\modules\baseSchedulesTypes\models;

use Yii;

/**
 * This is the model class for table "base_schedules_types".
 *
 * @property int $id
 * @property string $name
 * @property int $days
 */
class BaseSchedulesTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'base_schedules_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['days'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'days' => 'Количество дней',
        ];
    }
}
