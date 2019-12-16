<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "treatment_plan".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $author
 * @property int $patient
 * @property string $comments
 * @property int $deleted
 */
class TreatmentPlan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'treatment_plan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['author', 'patient', 'deleted'], 'integer'],
            [['comments'], 'string'],
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
            'author' => 'Author',
            'patient' => 'Patient',
            'comments' => 'Comments',
            'deleted' => 'Deleted',
        ];
    }
}
