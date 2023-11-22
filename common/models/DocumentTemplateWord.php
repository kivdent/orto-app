<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "document_template_word".
 *
 * @property int $id
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 * @property string $file_name
 * @property string $description
 * @property string $variables
 * @property int $employee_id
 */
class DocumentTemplateWord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'document_template_word';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['description'], 'string'],
            [['employee_id'], 'integer'],
            [['title', 'file_name', 'variables'], 'string', 'max' => 255],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'file_name' => 'File Name',
            'description' => 'Description',
            'variables' => 'Variables',
            'employee_id' => 'Employee ID',
        ];
    }
}
