<?php

use common\modules\invoice\widgets\form\InvoiceFormWidget;
use common\modules\pricelists\models\Pricelist;

/* @var $this yii\web\View*/
/* @var $appointment_id string*/
/* @var $patient_id string*/
/* @var $invoice_type string*/
/* @var $employee_choice boolean*/
$this->title='Создание счёта';
?>

<?= InvoiceFormWidget::widget([
    'type' => InvoiceFormWidget::TYPE_PAGE_INVOICE,
    'patient_id' => $patient_id,
    'appointment_id' => $appointment_id,
    'invoice_type' => $invoice_type,
    'employee_choice'=>$employee_choice
]) ?>
