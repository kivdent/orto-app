<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pricelist".
 *
 * @property int $id
 * @property string|null $title
 * @property int|null $active
 * @property string|null $type
 * @property string|null $specialization
 */
class Pricelist extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pricelist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'active', 'type', 'specialization'], 'default', 'value' => null],
            [['active'], 'integer'],
            [['title', 'type', 'specialization'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'active' => 'Active',
            'type' => 'Type',
            'specialization' => 'Specialization',
        ];
    }

}
