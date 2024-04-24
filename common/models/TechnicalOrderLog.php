<?php

namespace common\models;

use common\modules\employee\models\Employee;
use Yii;

/**
 * This is the model class for table "technical_order_log".
 *
 * @property int $id
 * @property int $technical_order_id
 * @property int $employee_id
 * @property string $created_at
 * @property int $status
 * @property string $comment
 * @property string $items
 *
 * @property Employee $employee
 * @property TechnicalOrder $technicalOrder
 */
class TechnicalOrderLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'technical_order_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['technical_order_id', 'employee_id', 'status'], 'integer'],
            [['created_at'], 'safe'],
            [['comment'], 'string'],
            [['items'], 'string', 'max' => 255],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['employee_id' => 'id']],
            [['technical_order_id'], 'exist', 'skipOnError' => true, 'targetClass' => TechnicalOrder::className(), 'targetAttribute' => ['technical_order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'technical_order_id' => 'Technical Order ID',
            'employee_id' => 'Employee ID',
            'created_at' => 'Created At',
            'status' => 'Status',
            'comment' => 'Comment',
            'items' => 'Items',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'employee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTechnicalOrder()
    {
        return $this->hasOne(TechnicalOrder::className(), ['id' => 'technical_order_id']);
    }
}
