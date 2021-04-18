<?php

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use common\modules\invoice\models\InvoiceSearch;
use yii\helpers\Html;
use common\modules\invoice\widgets\modalTable\InvoiceModalWidget;

/* @var $this yii\web\View */
/* @var ActiveDataProvider $dataProvider */
/* @var InvoiceSearch $searchModel */
$this->title='Счета пациента';
?>
    <h1><?=$this->title?></h1>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'format' => 'raw',
            'attribute' => 'patientFullName',
            'content' => function ($data) {
                return Html::a($data->patientFullName, ['/patient/manage/update', 'patient_id' => $data->patient_id], ['target' => '_blank']);
            }
        ],
        'date',
        [
            'format' => 'raw',
            'attribute' => 'employeeFullName',
            'filter' => InvoiceSearch::getEmployeeListWithInvoice(),

        ],
        [
            'attribute' => 'amount_payable',
            'format' => 'raw',
            'content' => function ($data) {
                $string = $data->amount_payable . ' р.';
                $string .= ($data->amount_residual == 0) ? '' : '(Долг: ' . $data->amount_residual . 'р.)';
                return $string;
            }
        ],

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {delete}',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return InvoiceModalWidget::widget(['invoice_id' => $model->id]);
                },
            ]
        ],
    ]
]) ?>