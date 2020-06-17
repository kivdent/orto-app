<?php

use common\modules\userInterface\models\UserInterface;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use common\modules\invoice\models\InvoiceSearch;
use yii\helpers\Html;
use common\modules\invoice\widgets\modalTable\InvoiceModalWidget;

/* @var $this yii\web\View */
/* @var ActiveDataProvider $dataProvider */
///* @var InvoiceSearch $searchModel */
?>
    <h1>Заказ наряды</h1>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    // 'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'label' => 'Пациент',
            'content' => function ($data) {
                return $data->patientFullName;
            }
        ],
        [
            'label' => 'Техник',
            'content' => function ($data) {
                return $data->technicFullName;
            }
        ], [
            'label' => 'Создан',
            'content' => function ($data) {
                return $data->technicalOrderInvoice->date;
            }
        ],
        [
            'label' => 'Дата сдачи',
            'content' => function ($data) {
                return UserInterface::getFormatedDate($data->delivery_date);
            }
        ],
        [
            'label' => 'Оплачен',
            'content' => function ($data) {
                return $data->isPaid() ? 'Оплачен '.UserInterface::getFormatedDate($data->invoice->lastPaymentDate):'Не оплачен';
            }
        ],



//
//        [
//            'format' => 'raw',
//            'attribute' => 'patientFullName',
//            'content' => function ($data) {
//                return Html::a($data->patientFullName, ['/patient/manage/view', 'patient_id' => $data->patient_id], ['target' => '_blank']);
//            }
//        ],
//
//        [
//            'attribute' => 'id',
//            'label' => 'Сумма заказ наряд',
//            'format' => 'raw',
//            'content' => function ($data) {
//                return InvoiceModalWidget::widget(['invoice_id' =>$data->id]).$data->amount_residual;
//            }
//        ],
//        'date',
//        [
//            'label' => 'Дата сдачи',
//            'format' => 'raw',
//            'content' => function ($data) {
//                return ;
//            }
//        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{show_tech_invoice}{show_invoice}',
            'buttons' => [
                'show_tech_invoice' => function ($url, $model, $key) {
                    return InvoiceModalWidget::widget([
                            'invoice_id' => $model->technical_order_invoice_id,
                        'text' => 'Наряд'
                    ]);
                },
                'show_invoice'=>function($url, $model, $key){
                    return InvoiceModalWidget::widget([
                        'invoice_id' => $model->invoice_id,
                        'text' => 'Счёт'
                    ]);
                }
            ]
        ],
    ]
]) ?>