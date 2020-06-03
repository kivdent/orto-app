<?php

use common\modules\clinic\models\FinancialDivisions;
use common\modules\employee\models\Employee;
use common\modules\invoice\widgets\modalTable\InvoiceModalWidget;
use common\modules\patient\models\Patient;
use kartik\date\DatePicker;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $cashbox \common\modules\cash\models\Cashbox */
/* @var $financial_report \common\modules\reports\models\FinancialReports */
/* @var $print boolean */
/* @var $divisions array */

$this->title = "Финансовый отчёт за " . date('d.m.Y');

foreach ($divisions as $division_id => $division_title) {
    echo Html::a('Печать отчёта ' . $division_title, ['daily-print', 'division_id' => $division_id,'date'=>Yii::$app->request->get('date')], ['class' => 'btn bth-xs btn-primary', 'target' => '_blank']);
}

?>
<?= DatePicker::widget([
    'name' => 'date_picker',
    'type' => DatePicker::TYPE_BUTTON,
    'value' => date('Y-m-d'),
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
    ],
    'options' => [
        'id' => 'date_picker',
    ],
    'pluginEvents' => [
        "changeDate" => "
 function(e) {
 $.fn.kvDatepicker.defaults.todayHighlight = true;
$.fn.kvDatepicker.defaults.format = 'yyyy-mm-dd';
        var d = $('#date_picker').kvDatepicker('getDate');
       
        console.log(d);
        var month = '' + (d.getMonth() + 1);
        var day = '' + d.getDate();
        var year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day
    var date=[year, month, day].join('-');
     console.log(date);
    window.location.href='/reports/financial/daily?date='+date;
 }",
    ]
]); ?>

<?= $this->render('_daily_form', [
    'cashbox' => $cashbox,
    'financial_report' => $financial_report,
    'divisions' => $divisions,
    'print' => $print,
]) ?>