<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "objectively_items".
 *
 * @property int $id
 * @property int $objectively_id
 * @property string $type

 */
class ObjectivelyItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'objectively_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['objectively_id', 'type'], 'required'],
            [['objectively_id'], 'integer'],

            [['type'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'objectively_id' => 'Objectively ID',
            'type' => 'Тип',

        ];
    }
}
