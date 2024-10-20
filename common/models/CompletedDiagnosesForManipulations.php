<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "completed_diagnoses_for_manipulations".
 *
 * @property int $id
 * @property int $completed_diagnoses_id
 * @property int $pricelist_items_id
 *

 */
class CompletedDiagnosesForManipulations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'completed_diagnoses_for_manipulations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['completed_diagnoses_id', 'pricelist_items_id'], 'integer'],
            [['completed_diagnoses_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompletedDiagnoses::className(), 'targetAttribute' => ['completed_diagnoses_id' => 'id']],
            [['pricelist_items_id'], 'exist', 'skipOnError' => true, 'targetClass' => PricelistItems::className(), 'targetAttribute' => ['pricelist_items_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'completed_diagnoses_id' => 'Completed Diagnoses ID',
            'pricelist_items_id' => 'Pricelist Items ID',
        ];
    }

//    /**
//     * @return \yii\db\ActiveQuery
//     */
//    public function getCompletedDiagnoses()
//    {
//        return $this->hasOne(CompletedDiagnoses::className(), ['id' => 'completed_diagnoses_id']);
//    }
//
//    /**
//     * @return \yii\db\ActiveQuery
//     */
//    public function getPricelistItems()
//    {
//        return $this->hasOne(PricelistItems::className(), ['id' => 'pricelist_items_id']);
//    }
}
