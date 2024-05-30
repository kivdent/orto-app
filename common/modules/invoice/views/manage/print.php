<?php
/* @var  $this \yii\web\View*/

use common\modules\invoice\widgets\form\InvoiceFormWidget;

/* @var $invoice \common\modules\invoice\models\Invoice*/
?>
<h4 class="modal-title" id="myModalLabel">Счёт № <?=$invoice->id?> от <?=$invoice->date?></h4>
<p>
    <?php if ($invoice->type==\common\modules\invoice\models\Invoice::TYPE_TECHNICAL_ORDER):?>
        Техник: <?=$invoice->getEmployeeFullName()?></br>
        Врач: <?=$invoice->technicalOrder->invoice->employeeFullName?></br>
    <?php else:?>
        Врач: <?=$invoice->getEmployeeFullName()?></br>
    <?php endif;?>
Пациент: <?=$invoice->getPatientFullName()?>
</p>
<p>
    <?php if ($invoice->type==\common\modules\invoice\models\Invoice::TYPE_TECHNICAL_ORDER && !empty($invoice->technicalOrder->comment)):?>
        Комментарий: <?=$invoice->technicalOrder->comment?>
    <?php endif;?>
</p>
<?= InvoiceFormWidget::getInvoiceTable($invoice->id)?>
<p>
    <?php if ($invoice->type==\common\modules\invoice\models\Invoice::TYPE_TECHNICAL_ORDER):?>
       <img src="/images/teeth_for_torder.jpg" height="50%" width="50%">
    <?php endif;?>
</p>
