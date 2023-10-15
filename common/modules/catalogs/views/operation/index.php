<?php

use common\modules\invoice\widgets\form\InvoiceFormWidget;
use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\pricelists\models\Pricelist;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\catalogs\models\OperationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Операции в плане лечения';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="operation-index">

        <h1><?= Html::encode($this->title) ?></h1>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a('Новая операция', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                'title',
                'actualPrice',
                'price_from',
                'price_to',
                'duration_from',
                'duration_to',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete} {compliance} {clear-compliance}',
                    'buttons' => [
                        'compliance' => function ($url, $model, $key) {
                            return Html::button('<span class="glyphicon glyphicon-th" aria-hidden="true"></span>', [
                                'class' => 'btn btn-primary btn-xs',
                                'id' => 'modal_compliance',
                                'data-toggle' => "modal",
                                'data-target' => "#invoice_form",
                                'data-recipient' => $model->id,
                                'data-recipient-item-class' => ".price_from",
                                'data-type' => 'operation',
                                'title'=>'Установить соответсвие'
                            ]);
                        },
                        'clear-compliance' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>',
                                ['clear-compliance','operation_id'=>$model->id],
                                [
                                    'class' => 'btn btn-primary btn-xs',
                                    'title'=>'Удалить соответсвие'
                                ]);
                        }
                    ]
                ],
            ],
        ]); ?>
    </div>
<?= InvoiceFormWidget::widget([
    'type' => InvoiceFormWidget::TYPE_MODAL_COMPLIANCE,
    'typePriceList' => [Pricelist::TYPE_MANIPULATIONS, Pricelist::TYPE_MATERIALS],
]) ?>