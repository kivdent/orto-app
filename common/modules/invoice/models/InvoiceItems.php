<?php


namespace common\modules\invoice\models;

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
}