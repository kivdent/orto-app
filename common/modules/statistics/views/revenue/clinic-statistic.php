<?php



/* @var $this \yii\web\View */
/* @var $clinicStatistic \common\modules\statistics\models\ClinicStatistic */
/* @var $type string\common\modules\statistics\models\ClinicStatistic */

use common\modules\invoice\widgets\modalTable\InvoiceModalWidget;
use common\modules\reports\widgets\financialPeriodChooseWidget\FinancialPeriodChooseWidget;
use yii\helpers\Html;

$this->title=$clinicStatistic->titles[$type];

$this->params['breadcrumbs'][] = ['label'=>'Выручка','url'=>['revenue/index','financialPeriodId'=>Yii::$app->request->get('financialPeriodId')]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= FinancialPeriodChooseWidget::widget(['link' => '/statistics/revenue/material','var' => 'financialPeriodId',])?>
<?= Html::a('2022',['/statistics/revenue/clinic-statistic','type'=>'getDoctors','year'=>2022])?><br>
<?=$this->title.": ".call_user_func([$clinicStatistic,$type.'Summary']);?>


<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#positions" aria-controls="positions" role="tab" data-toggle="tab">Позиции</a></li>
    <li role="presentation"><a href="#allDoctors" aria-controls="allDoctors" role="tab" data-toggle="tab">Таблица по врачам</a></li>
   </ul>

<!-- Tab panes -->

<!-- Positions -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="positions">
        <table class="table table-bordered">
            <?php foreach (call_user_func([$clinicStatistic,$type.'PriceListItems']) as $position):?>
                <tr>
                    <td><?=$position['title']?></td>
                    <td><?=$position['total']?></td>
                </tr>
            <?php endforeach;?>
        </table>
    </div>

    <!-- Doctors -->
    <div role="tabpanel" class="tab-pane" id="allDoctors">
<?=\common\widgets\tableWidget\TableWidget::widget([
        'table' => call_user_func([$clinicStatistic,$type.'PaymentsForTable'])['table'],
    'labels' =>  call_user_func([$clinicStatistic,$type.'PaymentsForTable'])['labels']])?>

    </div>

</div>

</div>

