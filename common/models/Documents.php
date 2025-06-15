<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "documents".
 *
 * @property int $id
 * @property string|null $hash
 * @property int|null $signed
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $employee_id
 */
class Documents extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hash', 'signed', 'created_at', 'updated_at', 'employee_id'], 'default', 'value' => null],
            [['signed', 'employee_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['hash'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hash' => 'Hash',
            'signed' => 'Signed',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'employee_id' => 'Employee ID',
        ];
    }

}
