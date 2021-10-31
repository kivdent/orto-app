<?php

namespace common\modules\schedule\models;

use yii\helpers\ArrayHelper;

class AppointmentContent extends \common\models\AppointmentContent
{
    public static function getContentList()
    {
        return ArrayHelper::map(self::find()->asArray()->all(),'id','SoderzhNaz');
    }
}