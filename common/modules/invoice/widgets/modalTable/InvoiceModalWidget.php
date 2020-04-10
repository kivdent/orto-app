<?php

namespace common\modules\invoice\widgets\modalTable;


class InvoiceModalWidget extends \yii\base\Widget
{
    public $invoice_id;

    public function run()
    {
        return $this->render('_table',[
            'invoice_id'=>$this->invoice_id
        ]);
    }
}