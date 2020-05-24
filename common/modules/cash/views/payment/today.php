<?php

use common\modules\cash\models\Cashbox;
use yii\helpers\Html;
use common\modules\invoice\models\Invoice;

/* @var $this yii\web\View */
/* @var \common\modules\invoice\models\Invoice $invoices array */
/* @var $invoice \common\modules\invoice\models\Invoice */
\common\modules\cash\assets\CashAsset::register($this);
$this->title = 'Оплаты за сгодня.'
?>
<h3>Оплаты на сегодня</h3>
<?php foreach ($invoices as $invoice): ?>
    <div class="panel panel-default">
        <div class="panel-heading"><?= $invoice->patientFullName ?></div>

        <table class="table table-condensed">

            <tbody>
            <?php foreach (Invoice::getPatientDebts($invoice->patient_id) as $debt_invoice): ?>
                <tr>
                    <td>

                        <?= $debt_invoice->date ?>

                        <?= Html::button('<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>', [
                            'class' => "btn btn-primary btn-xs modal-open",
                            //  'data-toggle'=>"modal",
                            //    'data-target'=>"#invoice-modal",
                            'invoice-id' => $debt_invoice->id,

                        ]) ?>
                        <?= $debt_invoice->type===Invoice::TYPE_MATERIALS ? '<span class="label label-info ">
                            <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
                         </span>':'';?>
                    </td>
                    <td><?= $debt_invoice->employeeFullName ?></td>
                    <td><?= $debt_invoice->amount_residual ?> рублей.</td>
                    <td> <?= Html::a('Принять оплату', ['pay', 'invoice_id' => $debt_invoice->id], [
                            'class' => 'btn btn-primary btn-xs'
                        ]); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    </div>
<?php endforeach; ?>


<!-- Modal -->
<div class="modal fade" id="invoice-modal" tabindex="-1" role="dialog" aria-labelledby="invoice-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->