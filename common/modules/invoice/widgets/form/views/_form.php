<?php

use common\modules\invoice\assets\InvoiceAsset;
use common\modules\pricelists\widgets\PriceListsWidget;
use yii\helpers\Html;

InvoiceAsset::register($this);
/* @var $priceLists \common\modules\catalogs\models\Pricelists */
/* @var $beforeHtml string*/
/* @var $afterHtml string*/
?>
<?=$beforeHtml?>
<div class="row" name="control">
    <div class="col-lg-12">
    </div>
</div>
<div class="row" name="invoice-table">
    <div class="col-lg-12">
        <div id="invoice">
            <table class="table table-bordered" id="invoice-table">
                <caption>Счёт за услуги:</caption>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Наименование</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Стоимость</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th class="text-right">Итого</th>
                    <th id="summary">0 р</th>
                    <td></td>

                </tr>
                </tfoot>
                <tbody id="invoice-table-body">

                </tbody>

            </table>
        </div>
    </div>
</div>
<?= PriceListsWidget::widget([
    'type'=>PriceListsWidget::TYPE_INVOICE,
    'typePriceLists' => $typePriceList,

])?>
<?=$afterHtml?>