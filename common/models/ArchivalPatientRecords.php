<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "archival_patient_records".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $archive_boxes_id
 * @property double $patient_id
 *
 * @property ArchiveBoxes $archiveBoxes
 */
class ArchivalPatientRecords extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'archival_patient_records';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['archive_boxes_id'], 'integer'],
            [['patient_id'], 'number'],
            [['archive_boxes_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArchiveBoxes::className(), 'targetAttribute' => ['archive_boxes_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'archive_boxes_id' => 'Archive Boxes ID',
            'patient_id' => 'Patient ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArchiveBoxes()
    {
        return $this->hasOne(ArchiveBoxes::className(), ['id' => 'archive_boxes_id']);
    }
}
