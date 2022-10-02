<?php


namespace common\modules\invoice\models;

use common\modules\invoice\models\Invoice;
use common\modules\pricelists\models\Prices;

/**
 * Class InvoiceItems
 * @package common\modules\invoice\models
 * @property integer $summary
 * @property integer $coefficientSummary
 * @property string $title
 *  @property Invoice $invoice
 * @property Prices $prices
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id' => 'invoice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrices()
    {
        return $this->hasOne(Prices::className(), ['id' => 'prices_id']);
    }
}