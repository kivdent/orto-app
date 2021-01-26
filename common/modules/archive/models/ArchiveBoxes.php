<?php


namespace common\modules\archive\models;


use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class ArchiveBoxes extends \common\models\ArchiveBoxes
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ]
        ];
    }
    public static function getCurrentBox()
    {
        return self::find()->orderBy('id DESC')->one()===null?'Нет коробов':self::find()->orderBy('id DESC')->one()->id;
    }
}