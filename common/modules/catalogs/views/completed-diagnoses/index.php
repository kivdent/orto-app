<?php

use common\modules\invoice\widgets\form\InvoiceFormWidget;
use common\modules\schedule\models\AppointmentsDay;
use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\pricelists\models\Pricelist;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\catalogs\models\CompletedDiagnosesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Законченные диагнозы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="completed-diagnoses-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Новый', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title',
                [
                    'attribute' => 'speciality',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return AppointmentsDay::getSpezializationLabels()[$model->speciality];
                    }
                ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete} {compliance}',
                'buttons' => [
                    'compliance' => function ($url, $model, $key) {
                        return Html::button('<span class="glyphicon glyphicon-th" aria-hidden="true"></span>', [
                            'class' => 'btn btn-primary btn-xs',
                            'id' => 'modal_compliance',
                            'data-toggle' => "modal",
                            'data-target' => "#invoice_form",
                            'data-recipient' => $model->id,
                            'data-recipient-item-class' => ".price_from",
                            'data-type' => 'completed_diagnoses',
                            'title'=>'Установить соответсвие'
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