<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "razd".
 *
 * @property int $id
 * @property string $Razd
 */
class DentistrySection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'razd';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Razd'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Razd' => 'Razd',
        ];
    }
}
