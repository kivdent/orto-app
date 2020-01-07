<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "objectively".
 *
 * @property int $id
 * @property string $name
 * @property string $text
 * @property string $type
 */
class Objectively extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'objectively';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['text'], 'string'],
            [['name'], 'string', 'max' => 60],
            [['type'], 'string', 'max' => 255],
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
            'text' => 'Текст',
            'type' => 'Тип',
        ];
    }
}
