<?php

use common\modules\userInterface\models\UserInterface;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use common\modules\invoice\models\InvoiceSearch;
use yii\helpers\Html;
use common\modules\invoice\widgets\modalTable\InvoiceModalWidget;
use common\modules\invoice\models\Invoice;

/* @var $this yii\web\View */
/* @var ActiveDataProvider $dataProvider */
/* @var InvoiceSearch $searchModel */
$this->title = 'Заказ-наряды';
\common\modules\invoice\assets\InvoiceAsset::register($this);
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
//        [
//            'format' => 'raw',
//            'attribute' => 'technicianFullName',
//            'filter' => InvoiceSearch::getEmployeeListWithInvoice(),
//        ],
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
            'template' => '{view}  {create} {edit} {delete} {complete}',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return InvoiceModalWidget::widget(['invoice_id' => $model->id]);

                },
                'create' => function ($url, $model, $key) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>',
                        ['/invoice/technical-order/create',
                            'invoice_id' => $model->id,
                            'invoice_type' => Invoice::TYPE_TECHNICAL_ORDER,],
                        ['class' => 'btn btn-primary btn-xs technical-order-complete',]
                    );
                },
                'edit' => function ($url, $model, $key) {
                    return $model->paid == 0 ? Html::a(
                        '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',
                        ['/invoice/technical-order/update',
                            'technical_order_id' => $model->technicalOrder->id,],
                        ['class' => 'btn btn-primary btn-xs technical-order-complete',]
                    ) : '';
                },
                'delete' => function ($url, $model, $key) {
                      if (!UserInterface::isUserRole(UserInterface::ROLE_TECHNICIAN)) {
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
                    }
                },
                'complete' => function ($url, $model, $key) {
                    if (!UserInterface::isUserRole(UserInterface::ROLE_TECHNICIAN)) {
                        return $model->technicalOrder->completed ? Html::button('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>', [
                            'class' => 'btn btn-danger btn-xs technical-order-complete',
                            'id' => $model->technicalOrder->id,
                        ]) : Html::button('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>', [
                            'class' => 'btn btn-success btn-xs technical-order-complete',
                            'id' => $model->technicalOrder->id,
                        ]);
                    }
                },

            ]
        ],
    ]
]) ?>