<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "soderzhnaz".
 *
 * @property int $id
 * @property string $SoderzhNaz
 */
class AppointmentContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'soderzhnaz';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SoderzhNaz'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'SoderzhNaz' => 'Soderzh Naz',
        ];
    }
}
