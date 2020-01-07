<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "objectively_sub_Items".
 *
 * @property int $id
 * @property int $objectively_Items_id
 * @property string $value
 */
class ObjectivelySubItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'objectively_sub_Items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['objectively_Items_id', 'value'], 'required'],
            [['objectively_Items_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'objectively_Items_id' => 'Objectively Items ID',
            'value' => 'Содержание',
        ];
    }
}
