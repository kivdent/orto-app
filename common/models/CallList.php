<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "call_list".
 *
 * @property int $id
 * @property string $title
 * @property string $Description
 * @property string $created_at
 * @property string $updated_at
 * @property int $employee_id
 * @property string $type
 * @property string $status
 *
 * @property CallListTasks[] $callListTasks
 */
class CallList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'call_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'employee_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['employee_id'], 'integer'],
            [['title', 'Description', 'type', 'status'], 'string', 'max' => 255],
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
            'Description' => 'Description',
            'created_at' => 'Crated At',
            'updated_at' => 'Updated At',
            'employee_id' => 'Employee ID',
            'type' => 'Type',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCallListTasks()
    {
        return $this->hasMany(CallListTasks::className(), ['call_list_id' => 'id']);
    }
}