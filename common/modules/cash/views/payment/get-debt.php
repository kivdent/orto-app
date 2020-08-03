<?php

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use common\modules\invoice\models\InvoiceSearch;
use yii\helpers\Html;
use common\modules\invoice\widgets\modalTable\InvoiceModalWidget;
use common\modules\invoice\models\Invoice;

/* @var $this yii\web\View */
/* @var ActiveDataProvider $dataProvider */
/* @var InvoiceSearch $searchModel */
?>
    <h1>Долги пациентов</h1>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'format' => 'raw',
            'attribute' => 'patientFullName',
            'content' => function ($data) {
                return Html::a($data->patientFullName, ['/patient/manage/view', 'patient_id' => $data->patient_id], ['target' => '_blank']);
            }
        ],

        [
            'format' => 'raw',
            'attribute' => 'employeeFullName',
            'filter' => InvoiceSearch::getEmployeeListWithInvoice(),

        ],

        [
            'attribute' => 'amount_residual',
            'format' => 'raw',
            'content' => function ($data) {
                $material= $data->type === Invoice::TYPE_MATERIALS ? '<span class="label label-info ">
                            <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
                         </span>' : '';
                return InvoiceModalWidget::widget(['invoice_id' =>$data->id]).$data->amount_residual.$material;
            }
        ],
        'date',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{pay}',
            'buttons' => [
                'pay' => function ($url, $model, $key) {
                    return Html::a('Принять оплату', ['pay', 'invoice_id' => $model->id], ['class' => 'btn btn-primary btn-xs']);

                },
            ]
        ],
    ]
]) ?>