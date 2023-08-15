<?php

namespace common\modules\clinic\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "rabmesto".
 *
 * @property int $id
 * @property string $nazv
 * @property int $clinic_id
 */
class Workplaces extends \common\abstractClasses\ActiveRecordEntity
{
    

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rabmesto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clinic_id'], 'integer'],
            [['nazv'], 'string', 'max' => 255],
            [['nazv'], 'required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nazv' => 'Название',
            'clinic_id' => 'Клиника',
        ];
    }
    public static function getWorkplacesList(){
        $list=self::find()->asArray()->all();
        $list=ArrayHelper::map($list,'id','nazv');
        return $list;
    }
}
