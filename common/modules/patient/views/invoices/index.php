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
$this->title = 'Счета пациента';
?>
    <h1><?= $this->title ?></h1>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

//        [
//            'format' => 'raw',
//            'attribute' => 'patientFullName',
//            'content' => function ($data) {
//                return Html::a($data->patientFullName, ['/patient/manage/view', 'patient_id' => $data->patient_id], ['target' => '_blank']);
//            }
//        ],
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
            'template' => '{view}  {create} {edit} {delete} {record}',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return InvoiceModalWidget::widget(['invoice_id' => $model->id]);

                },
                'create' => function ($url, $model, $key) {
                    $class_create = ($model->hasTechnicalItemsCompliance() and !$model->hasTechnicalOrderForInvoice()) ? 'btn btn-danger btn-xs technical-order-complete' : 'btn btn-primary btn-xs technical-order-complete';
                    return Html::a(
                        '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>',
                        ['/invoice/technical-order/create',
                            'invoice_id' => $model->id,
                            'invoice_type' => Invoice::TYPE_TECHNICAL_ORDER,],
                        ['class' => $class_create,]
                    );

                },
                'edit' => function ($url, $model, $key) {
                    return $model->paid == 0 ? Html::a(
                        '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',
                        ['/invoice/manage/update',
                            'invoice_id' => $model->id,],
                        ['class' => 'btn btn-primary btn-xs technical-order-complete',]
                    ) : '';
                },
                'record' => function ($url, $model, $key) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-comment" aria-hidden="true"></span>',
                        ['/patient/records/create',
                            'patient_id'=>$model->patient_id,
                            'invoice_id' => $model->id,],
                        ['class' => 'btn btn-primary btn-xs',]
                    );
                },
                'delete' => function ($url, $model, $key) {
                    return $model->paid == 0 ? Html::a(
                        '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>',
                        ['/invoice/manage/delete',
                            'id' => $model->id,
                        ],
                        ['class' => 'btn btn-danger btn-xs technical-order-complete',
                            'data' => [
                                'confirm' => 'Вы уверены, что хотите удалить счёт?',
                                'method' => 'post',
                            ],
                        ]
                    ) : '';
                },

            ]
        ],
    ]
]) ?>