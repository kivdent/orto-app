<?php
use yii\grid\GridView;
use common\widgets\tableWidget\TableWidget;
/* @var $this \yii\web\View */
/* @var $daily_report \common\modules\reports\models\DailyReport */
/* @var $dataProvider \yii\data\ArrayDataProvider */
$this->title = 'Финансовый отчет сотрудника ' . Yii::$app->user->identity->employe->fullName . ' за ' . date('d.m.Y');

 ?>
<h4><?= $this->title ?></h4>
Выписано чеков: <?=$daily_report->invoiceSummary?><br>
Сумма балов: <?=$daily_report->coefficient_summary?><br>
<?= TableWidget::widget([
    'table' => $daily_report->table,
    'labels' => $daily_report->labels
]) ?>

