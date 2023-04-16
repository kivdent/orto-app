<?php

use common\modules\invoice\widgets\form\InvoiceFormWidget;
use common\modules\pricelists\models\Pricelist;

/* @var $this yii\web\View */
/* @var $appointment_id string */
/* @var $patient_id string */
/* @var $invoice_type string */
/* @var $employee_choice boolean */
$this->title = 'Выбор пациентов с манипуляциями';
//$this->registerJs("$('#send_request_for_patients_button').click(send_request_for_patients());",\yii\web\View::POS_END)
?>
<h1><?= $this->title ?></h1>
<?= \yii\helpers\Html::button('Список пациентов',['id'=>'send_request_for_patients_button','class'=>'btn btn-default','type'=>'button']) ?>
<?= InvoiceFormWidget::widget([
    'type' => InvoiceFormWidget::TYPE_SIMPLE,
    'priceListWidgetType' => \common\modules\pricelists\widgets\PriceListsWidget::TYPE_INVOICE_STAT
]) ?>