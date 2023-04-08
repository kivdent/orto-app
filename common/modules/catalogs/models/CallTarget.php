<?php

namespace common\modules\catalogs\models;

use yii\helpers\ArrayHelper;

class CallTarget extends \common\models\CallTarget
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