<?php

namespace common\modules\schedule\models;

use yii\helpers\ArrayHelper;

class AppointmentContent extends \common\models\AppointmentContent
{
    public static function getContentList()
    {
        return ArrayHelper::map(self::find()->orderBy('SoderzhNaz')->asArray()->all(),'id','SoderzhNaz');
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'SoderzhNaz' => 'Содержание назаначения',
        ];
    }
}