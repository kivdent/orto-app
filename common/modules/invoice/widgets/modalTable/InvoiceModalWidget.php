<?php

namespace common\modules\invoice\widgets\modalTable;


class InvoiceModalWidget extends \yii\base\Widget
{
    public $invoice_id;
    public $text='<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>';

    public function run()
    {
        return $this->render('_table',[
            'invoice_id'=>$this->invoice_id,
            'text'=>$this->text,
        ]);
    }
}