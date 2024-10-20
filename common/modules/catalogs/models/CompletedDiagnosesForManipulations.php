<?php

namespace common\modules\catalogs\models;
use common\modules\catalogs\models\CompletedDiagnoses;
use common\modules\pricelists\models\PricelistItems;

/**
 *
 * @property-read PricelistItems $pricelistItems
 * @property-read CompletedDiagnoses $completedDiagnoses
 */
class CompletedDiagnosesForManipulations extends \common\models\CompletedDiagnosesForManipulations
{
    /**
     * @return CompletedDiagnoses
     */
    public function getCompletedDiagnoses()
    {
        return $this->hasOne(CompletedDiagnoses::className(), ['id' => 'completed_diagnoses_id']);
    }

    /**
     * @return PricelistItems
     */
    public function getPricelistItems()
    {
        return $this->hasOne(PricelistItems::className(), ['id' => 'pricelist_items_id']);
    }
}