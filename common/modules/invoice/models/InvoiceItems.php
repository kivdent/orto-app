<?php


namespace common\modules\invoice\models;

use common\modules\invoice\models\Invoice;
/**
 * Class InvoiceItems
 * @package common\modules\invoice\models
 * @property integer $summary
 * @property integer $coefficientSummary
 * @property string $title
 */
class InvoiceItems extends \common\models\InvoiceItems
{
    public function getSummary()
    {
    return $this->quantity*$this->prices->price;
    }
    public function getCoefficientSummary(){
        return $this->quantity*$this->prices->coefficient;
    }
    public function getTitle(){
        return $this->prices->title;
    }
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id' => 'invoice_id']);
    }
}