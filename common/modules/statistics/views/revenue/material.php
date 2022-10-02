<?php

/* @var $this \yii\web\View */
/* @var $material \common\modules\statistics\models\Material */

use common\modules\invoice\widgets\modalTable\InvoiceModalWidget;
use common\modules\reports\widgets\financialPeriodChooseWidget\FinancialPeriodChooseWidget;
use yii\helpers\Html;

$this->title='Материалы'
?>
<?= FinancialPeriodChooseWidget::widget(['link' => '/statistics/revenue/material','var' => 'financialPeriodId',])?></br>
<?="Сумма за период по средствам гигиены: ".$material->summary.
Html::a('Подробнее',
    ['revenue/hygiene-product','financialPeriodId'=>Yii::$app->request->get('financialPeriodId')],
    ['class'=>'btn btn-success btn-xs'])?>
    <br>
<?php foreach ($material->allPositionsByPricelistType as $position):?>
    <?= InvoiceModalWidget::widget(['invoice_id' => $position->invoice_id])?>
    <?=$position->invoice->created_at." ".$position->summary?></br>
<?php endforeach;?>