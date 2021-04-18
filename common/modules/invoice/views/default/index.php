<?php

use common\modules\invoice\assets\InvoiceAsset;
use common\modules\invoice\widgets\form\InvoiceFormWidget;
use yii\helpers\ArrayHelper;

?>
<button type="button" class="btn btn-primary btn-lg " data-toggle="modal" data-target="#invoice_form" data-recipient="#recipient">
    Калькулятор
</button>
<input id="recipient" class="recipient">
<?= InvoiceFormWidget::widget([
    'priceListIds' => ['1','3','4','6','7','8','10',],
    'type' => 'modal',
]) ?>
