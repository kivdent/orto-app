<?php


namespace common\modules\catalogs\models;


class Manipulations extends \common\models\Manipulations
{
    public function getManipulationsFromCategory()
    {
        return self::find()->where(['UpId' => $this->id])->all();
    }
}