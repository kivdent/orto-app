<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\pricelists\models\Pricelist;

//use wbraganca\dynamicform\DynamicFormWidget заменён на kidzen\dynamicform\DynamicFormWidget, для совместимости с kartik\select2\Select2;
use kartik\select2\Select2;
use kidzen\dynamicform\DynamicFormWidget;
use common\modules\patient\assets\TreatmentPlanAsset;
use common\modules\catalogs\widgets\DiagnosisInputWidget;
use common\modules\invoice\widgets\form\InvoiceFormWidget;

/* @var $this yii\web\View */
/* @var $model common\modules\patient\models\TreatmentPlanForm */
/* @var $modelsPlanItem common\modules\patient\models\PlanItem */
/* @var $form yii\widgets\ActiveForm */

TreatmentPlanAsset::register($this);
$classification = 13;//9 id классификации МКБ-10
?>

<div class="treatment-plan-form" id="treatment-plan-body">
    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'diagnosis_id')->widget(DiagnosisInputWidget::classname()); ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'comments')->textarea(['rows' => 2]) ?>
        </div>

        <div class="col-lg-2">
            <?= $form->field($model, 'status')->dropDownList(\common\modules\patient\models\TreatmentPlan::getStatusList()) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-th-list"></i> План лечения</h4></div>
        <div class="panel-body">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 999, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsPlanItem[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'region_id',
                    'operation_id',
                    'price_from',
                    'price_to',
                    "duration_from",
                    "duration_to",
                    'comment',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
                <?php foreach ($modelsPlanItem as $i => $modelItem): ?>
                    <div class="item panel panel-default"><!-- widgetBody -->
                        <div class="panel-heading">
                            <h3 class="panel-title pull-left">Рекомендация</h3>
                            <div class="pull-right">
                                <button type="button" class="add-item btn btn-success btn-xs"><i
                                            class="glyphicon glyphicon-plus"></i></button>
                                <button type="button" class="remove-item btn btn-danger btn-xs"><i
                                            class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body operation-block">
                            <?php
                            // necessary for update action.
                            if (!$modelItem->isNewRecord) {
                                echo Html::activeHiddenInput($modelItem, "[{$i}]id");
                            }
                            ?>

                            <div class="row">
                                <div class="col-sm-4">
                                    <?= $form->field($modelItem, "[{$i}]region_id")->
                                    widget(Select2::classname(), [
                                        'data' => \common\modules\patient\models\Region::getList(),
                                        'value'=>\common\modules\patient\models\Region::TYPE_ALL,
                                        'options' => ['placeholder' => 'Выберете область ...'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                    ?>
                                </div>
                                <div class="operation-block">
                                    <div class="col-sm-4">
                                        <?= $form->field($modelItem, "[{$i}]operation_id")
                                            ->widget(Select2::classname(), [
                                                'data' => \common\modules\patient\models\Operation::getList(),
                                                'value'=>\common\modules\patient\models\Operation::FROM_COMMENT,
                                                'options' => [
                                                    'placeholder' => 'Выберете рекомендацию ...',
                                                    'class' => 'operation_id',
                                                ],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <?= $form->field($modelItem, "[{$i}]comment")->textarea(['maxlength' => true]) ?>
                                </div>
                            </div>

                            <div class="row">

                                <div class="price-block-interval" >

                                    <div class="col-sm-2 ">

                                        <?= $form->field($modelItem, "[{$i}]price_from")->textInput([
                                            'class' => 'form-control price_from',
                                        ])->label('Стоимость от ' . Html::button('<span class="glyphicon glyphicon-th" aria-hidden="true"></span>', [
                                                'class' => 'btn btn-primary btn-xs',
                                                'data-toggle' => "modal",
                                                'data-target' => "#invoice_form",
                                                'data-type' => "plan_item",
                                                'data-recipient' => "find",
                                                'data-recipient-item-class' => ".price_from",
                                                'data-operation-id' => 'null',
                                            ]));
                                        ?>
                                    </div>

                                    <div class="col-sm-2">
                                        <?= $form->field($modelItem, "[{$i}]price_to")->textInput([
                                            'class' => 'form-control price_to',
                                        ]);
                                        ?>
                                    </div>
                                </div>


                                <div class="price-block-price-actual" hidden >
                                    <div class="col-sm-4">
                                        <label class="control-label" for="actualPrice">Стоимость</label>
                                        <?= Html::input('text', 'actualPrice',
                                            $modelItem->price_actual,
                                            [
                                                'class' => 'form-control price-actual',
                                                'disabled'
                                            ]);
                                        ?>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <?= $form->field($modelItem, "[{$i}]duration_from")->textInput();
                                    ?>
                                </div>

                                <div class="col-sm-2">
                                    <?= $form->field($modelItem, "[{$i}]duration_to")->textInput();
                                    ?>
                                </div>

                            </div> <!-- .row -->

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Сохранить' : 'Обновить', ['class' => 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>
    <?= InvoiceFormWidget::widget([
        'type' => InvoiceFormWidget::TYPE_MODAL_CALCULATOR,
        'typePriceList' => [Pricelist::TYPE_MANIPULATIONS, Pricelist::TYPE_MATERIALS],
    ]) ?>
</div>
