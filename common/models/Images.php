<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "images".
 *
 * @property int $id
 * @property int $author_id
 * @property int $patient_id
 * @property string $description
 * @property string $file_name
 * @property string $created_at
 * @property string $updated_at
 */
class Images extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id', 'patient_id'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['file_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'patient_id' => 'Patient ID',
            'description' => 'Description',
            'file_name' => 'File Name',
            'created_at' => 'Cerated At',
            'updated_at' => 'Updated At',
        ];
    }
}
