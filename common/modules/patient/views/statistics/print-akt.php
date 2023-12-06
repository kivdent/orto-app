<?php
/* @var  $this \yii\web\View */

/* @var  $invoices \common\modules\invoice\models\Invoice[] */

use common\modules\clinic\models\Clinic;
use common\modules\invoice\widgets\form\InvoiceFormWidget;
use common\modules\clinic\models\FinancialDivisions;

/* @var $invoice \common\modules\invoice\models\Invoice */

$i = 1;
$summ = 0;
$html = '';
foreach ($invoices as $invoice) {
    foreach ($invoice->invoiceItems as $invoiceItem) {
        $html .= '
                        <tr>
                            <td>' . $i . '</td>
                          
                            <td>' . $invoiceItem->prices->pricelistItems->title . '</td>
                            <td>' . $invoiceItem->prices->price . ' р.</td>
                            <td>' . $invoiceItem->quantity . '</td>
                            <td>' . $invoiceItem->summary . ' р.</td>   
                        </tr>';
        $summ += $invoiceItem->summary;
        $i++;
    }
}
?>


<div class="small">
    <p class="text-center">
        Акт выполненных работ за <?= Yii::$app->request->get('year') ?> год
        от <?= date('d.m.Y') ?>
    </p>
    <div class="row">
        <div class="col-xs-12">
            Исполнитель: <?= Clinic::getClinicInstance()->name ?> <?= Clinic::getClinicInfoString() ?>,
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            Заказчик: <?= $invoice->patientFullName ?>, адрес: <?= $invoice->patient->addressString ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>

                    <th>Наименование</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Стоимость</th>

                </tr>
                </thead>
                <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th class="text-right">Итого</th>
                    <th id="summary"><?= $summ ?></th>
                </tr>
                </tfoot>
                <tbody>
                <?= $html ?>
                </tbody>

            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            Вышеперечисленные услуги выполнены полностью и в срок. Заказчик претензий по объему, качеству и срокам
            оказания услуг не имеет.
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">Заказчик ________<?= $invoice->getPatientFullName() ?></div>
        <div class="col-xs-6">Исполнитель ________<?= Yii::$app->user->identity->employe->fullName ?></div>
    </div>
</div>