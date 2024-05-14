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
<?= InvoiceFormWidget::getInvoiceTable($invoice->id)?>
