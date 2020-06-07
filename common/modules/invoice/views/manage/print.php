<?php
/* @var  $this \yii\web\View*/

use common\modules\invoice\widgets\form\InvoiceFormWidget;

/* @var $invoice \common\modules\invoice\models\Invoice*/
?>
<h4 class="modal-title" id="myModalLabel">Счёт № <?=$invoice->id?> от <?=$invoice->date?></h4>
                                <p>
Врач: <?=$invoice->getEmployeeFullName()?></br>
Пациент: <?=$invoice->getPatientFullName()?>
</p>
<?= InvoiceFormWidget::getInvoiceTable($invoice->id)?>
