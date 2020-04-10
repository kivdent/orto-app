<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "opl_vid".
 *
 * @property int $id
 * @property string $vid
 */
class PaymentType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'opl_vid';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vid'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vid' => 'Vid',
        ];
    }
}
