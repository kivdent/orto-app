<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "archive_boxes".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 */
class ArchiveBoxes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'archive_boxes';
    }

    public static function getBoxesList()
    {
        return ArrayHelper::map(self::find()->orderBy('id DESC')->asArray()->all(), 'id', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
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
        ];
    }
}
