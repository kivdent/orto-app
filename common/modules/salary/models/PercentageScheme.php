<?php


namespace common\modules\salary\models;


use yii\helpers\ArrayHelper;

class PercentageScheme extends \common\models\PercentageScheme
{
    public static function getTypeList()
    {
        return ArrayHelper::map(self::find()->asArray()->all(), 'id', 'naim');
    }
}