<?php


namespace common\modules\invoice\models;

/**
 * Class InvoiceItems
 * @package common\modules\invoice\models
 * @property integer $summary
 */
class InvoiceItems extends \common\models\InvoiceItems
{
    public function getSummary()
    {
    return $this->quantity*$this->prices->price;
    }
}