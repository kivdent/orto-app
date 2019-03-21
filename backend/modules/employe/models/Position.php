<?php

namespace backend\modules\employe\models;

use Yii;

/**
 * This is the model class for table "dolzh".
 *
 * @property int $id
 * @property string $dolzh
 */
class Position extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dolzh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dolzh'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dolzh' => 'Dolzh',
        ];
    }
}
