<?php

namespace common\modules\api\models;

class Diagnosis extends \common\modules\catalogs\models\Diagnosis
{
    public function fields()
    {
        return [
            'id',
            'title' => 'Nazv',
            'code' => function () {
                return $this->code ? $this->code : '';
            }
        ];
    }
}