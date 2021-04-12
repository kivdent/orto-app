<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\pricelists\widgets\PriceListsWidget;
use kartik\file\FileInput;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $priceListId string */

$this->title = 'Пакетное изменение прейскурантов';

?>
<div class="pricelist-index">
    <h1><?= Html::encode($this->title) ?> </h1>
    <div class="row" name="control1">
        <div class="col-lg-2">
            <?= Html::input('number', 'percent', '5',
                [
                    'min' => 0,
                    'max' => 25,
                    "size" => 5,
                    'name' => 'percent',
                    'id' => 'percent',
                    'class' => 'form-control'
                ]) ?>
        </div>
        <div class="col-lg-5">
            <?= Html::button('Применить процент', [
                'class' => 'btn btn-success btn-xs',
                'id' => 'batch-editing-apply',
            ]) ?>
            <?= Html::button('Сохранить процент', [
                'class' => 'btn btn-success btn-xs',
                'id' => 'batch-editing-save',
            ]) ?>
        </div>
        <div class="col-lg-5">
            <div class="col-lg-12">

                <?php
                                Modal::begin([
                                    'header' => 'Загрузить черновик',
                                    'toggleButton' => [
                                        'label' => 'Загрузить черновик', 'class' => 'btn btn-primary btn-xs'
                                    ],
                                    'options' => [
                                            'id'=>'upload-draft-modal'
                                    ]
                                ]);
                ?>
                <?= FileInput::widget([
                    'name' => 'upload-draft',

                    'options' => [

                        'multiple' => false,
                        'id' => 'upload-draft',

                    ],
                    'pluginOptions' => [
                        'previewFileType' => 'xls',

                        'uploadUrl' => 'upload-draft',
                        'id' => 'upload-draft',
                    ],

                ]); ?>

                <?php
                                Modal::end();
                ?>


                <?= Html::button('Сохранить черновик', [
                    'class' => 'btn btn-success btn-xs',
                    'id' => 'save-draft',
                ]) ?>
            </div>
        </div>
    </div>
    <div class="row" name="control2">

    </div>

    <?= PriceListsWidget::widget([
        'type' => PriceListsWidget::TYPE_BATCH_EDITING,
        'activePriceList' => $priceListId
    ]) ?>
</div>
