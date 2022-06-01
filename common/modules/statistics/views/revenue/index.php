<?php

use common\modules\invoice\widgets\modalTable\InvoiceModalWidget;
use common\modules\statistics\models\ClinicStatistic;
use common\modules\statistics\models\HygieneProducts;
use common\modules\statistics\models\Material;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var  $hygieneProductsStatistics HygieneProducts  */

/* @var  $clinicStatistic ClinicStatistic  */
?>

<?=\common\modules\reports\widgets\financialPeriodChooseWidget\FinancialPeriodChooseWidget::widget(['link' => '/statistics/revenue','var' => 'financialPeriodId',])?><br>
<?="Сумма за период по средствам гигиены: ".$hygieneProductsStatistics->summary.
Html::a('Подробнее',
    ['revenue/hygiene-product','financialPeriodId'=>Yii::$app->request->get('financialPeriodId')],
    ['class'=>'btn btn-success btn-xs'])?>
<br>


<?="Сумма за период по материалам: ".$clinicStatistic->materialSummary.'(без гигиены '.($clinicStatistic->materialSummary-$hygieneProductsStatistics->summary).')'.
Html::a('Подробнее',
    ['revenue/clinic-statistic','financialPeriodId'=>Yii::$app->request->get('financialPeriodId'),'type'=>'getMaterial'],
    ['class'=>'btn btn-success btn-xs'])?>
<br>

<?="Сумма выручки врачей по клинике: ".$clinicStatistic->doctorsSummary.
Html::a('Подробнее',
    ['revenue/clinic-statistic','financialPeriodId'=>Yii::$app->request->get('financialPeriodId'),'type'=>'getDoctors'],
    ['class'=>'btn btn-success btn-xs'])?>
<br>

<?="Сумма общей выручки по клинике: ".$clinicStatistic->commonSummary.
Html::a('Подробнее',
    ['revenue/clinic-statistic','financialPeriodId'=>Yii::$app->request->get('financialPeriodId'),'type'=>'getCommon'],
    ['class'=>'btn btn-success btn-xs'])?>
<br>