<?php

use common\modules\clinic\models\FinancialDivisions;
use common\modules\employee\models\Employee;
use common\modules\invoice\widgets\modalTable\InvoiceModalWidget;
use common\modules\patient\models\Patient;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $cashbox \common\modules\cash\models\Cashbox */
/* @var $financial_report \common\modules\reports\models\FinancialReports */
/* @var $print boolean */
/* @var $divisions array */

$this->title = "Финансовый отчёт за " . date('d.m.Y');
foreach ($divisions as $division_id=>$division_title){
    echo Html::a('Печать отчёта '.$division_title,['daily-print','division_id'=>$division_id],['class'=>'btn bth-xs btn-primary','target'=>'_blank']);
}

?>

<?= $this->render('_daily_form', [
    'cashbox' => $cashbox,
    'financial_report' => $financial_report,
    'divisions' => $divisions,
    'print'=>$print,
]) ?>


