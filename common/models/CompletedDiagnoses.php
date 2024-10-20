<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "completed_diagnoses".
 *
 * @property int $id
 * @property string $title
 * @property string $speciality
 *
 */
class CompletedDiagnoses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'completed_diagnoses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'speciality'], 'string', 'max' => 255],
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
            'speciality' => 'Speciality',
        ];
    }


}
