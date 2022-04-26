<?php

use common\modules\invoice\widgets\modalTable\InvoiceModalWidget;
use common\modules\statistics\models\HygieneProducts;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var  $hygieneProductsStatistics HygieneProducts  */
?>
<?=\common\modules\reports\widgets\financialPeriodChooseWidget\FinancialPeriodChooseWidget::widget(['link' => '/statistics/revenue','var' => 'financialPeriodId',])?></br>
<?="Сумма за период по средствам гигиены: ".$hygieneProductsStatistics->summary.
Html::a('Подробнее',
    ['revenue/hygiene-product','financialPeriodId'=>Yii::$app->request->get('financialPeriodId')],
    ['class'=>'btn btn-success btn-xs'])?>
</br>
<?php foreach ($hygieneProductsStatistics->allPositions as $position):?>
<?= InvoiceModalWidget::widget(['invoice_id' => $position->invoice_id])?>
<?=$position->invoice->created_at." ".$position->summary?></br>
<?php endforeach;?>