<?php

namespace common\modules\catalogs\models;

use yii\helpers\ArrayHelper;

class RejectionReasons extends \common\models\RejectionReasons
{

    public static function getList()
    {
        $list = self::find()->asArray()->all();
        $list = ArrayHelper::map($list, 'id', 'title');
        return $list;
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
        ];
    }
}