<?php

/* @var $this \yii\web\View */
/* @var $hygieneProductsStatistics \common\modules\statistics\models\HygieneProducts */

use common\modules\invoice\widgets\modalTable\InvoiceModalWidget;
use common\modules\reports\widgets\financialPeriodChooseWidget\FinancialPeriodChooseWidget;
use yii\helpers\Html;

$this->title='Продажа гигиены';
$this->params['breadcrumbs'][] = ['label'=>'Выручка','url'=>['revenue/index','financialPeriodId'=>Yii::$app->request->get('financialPeriodId')]];
$this->params['breadcrumbs'][] = $this->title;
//\common\modules\userInterface\models\UserInterface::getVar($hygieneProductsStatistics->getGroupPositionsByPricelistType());
?>

<?= FinancialPeriodChooseWidget::widget(['link' => '/statistics/revenue','var' => 'financialPeriodId',])?><br>

<?="Сумма за период по средствам гигиены: ".$hygieneProductsStatistics->summary.
Html::a('Подробнее',
    ['revenue/hygiene-product','financialPeriodId'=>Yii::$app->request->get('financialPeriodId')],
    ['class'=>'btn btn-success btn-xs'])?>


<div>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#positions" aria-controls="positions" role="tab" data-toggle="tab">Позиции</a></li>
        <li role="presentation"><a href="#invoices" aria-controls="invoices" role="tab" data-toggle="tab">Счета</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="positions">
            <table class="table table-bordered">
                <?php foreach ($hygieneProductsStatistics->getGroupPositionsByPricelistType() as $position):?>
                    <tr>
                        <td><?=$position['title']?></td>
                        <td><?=$position['total']?></td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane" id="invoices">
            <?php foreach ($hygieneProductsStatistics->getAllPositionsByPricelistType() as $position):?>

                <?= InvoiceModalWidget::widget(['invoice_id' => $position->invoice_id])?>
                <?= $position->invoice->created_at." ".$position->invoice->employeeFullName." ".$position->invoice->amount_payable?><br>

            <?php endforeach;?>
        </div>
    </div>

</div>


