<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\catalogs\models\Complaints;
use kartik\tree\TreeViewInput;
use common\modules\patient\assets\MedicalRecordAsset;
use yii\web\View;
use common\modules\patient\models\Region;
use common\modules\catalogs\models\Anamnesis;
use common\modules\catalogs\models\Recommendations;
use common\modules\catalogs\models\Prescriptions;
use common\modules\catalogs\widgets\DiagnosisInputWidget;
use common\modules\catalogs\models\Objectively;
use common\modules\catalogs\models\Therapy;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model common\modules\patient\models\MedicalRecords */
/* @var $form yii\widgets\ActiveForm */

MedicalRecordAsset::register($this);
$this->registerJs(
    Complaints::getArrayScript(),
    View::POS_HEAD,
    'ComplaintsArray'
);
$this->registerJs(
    Anamnesis::getArrayScript(),
    View::POS_HEAD,
    'AnamnesisArray'
);
$this->registerJs(
    Recommendations::getArrayScript(),
    View::POS_HEAD,
    'RecommendationsArray'
);
$this->registerJs(
    Prescriptions::getArrayScript(),
    View::POS_HEAD,
    'PrescriptionsArray'
);


?>

<div class="medical-records-form">


    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, "date")->
            widget(
                DatePicker::classname(), [

                'options' => ['placeholder' => 'Дата вступления в силу....'],
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy'
                ]
            ]);
            ?>
        </div><div class="col-lg-3">
            <?= $form->field($model, "region_id")->
            widget(Select2::classname(), [
                'data' => Region::getList(),
                'options' => ['placeholder' => 'Выберете область ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>

        <div class="col-lg-3">

            <?= $form->field($model, 'diagnosis_id')->
            widget(DiagnosisInputWidget::classname());
            ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'invoice_id')->textInput() ?>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'complaints')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-lg-8">
            <?php echo TreeViewInput::widget([
                'id' => 'ComplaintsInput',
                'name' => 'ComplaintsInput',
                'value' => 'false', // preselected values
                'query' => Complaints::find()->addOrderBy('root, lft'),
                'headingOptions' => ['label' => 'Жалобы'],
                'rootOptions' => ['label' => '<i class="fas fa-tree text-success"></i>'],
                'fontAwesome' => true,
                'asDropdown' => false,
                'multiple' => false,
                'options' => ['disabled' => false,],
                'treeOptions' => ['style' => 'height:150px']
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'anamnesis')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-lg-8">
            <?php echo TreeViewInput::widget([
                'id' => 'AnamnesisInput',
                'name' => 'AnamnesisInput',
                'value' => 'true', // preselected values
                'query' => Anamnesis::find()->addOrderBy('root, lft'),
                'headingOptions' => ['label' => 'Анамнез'],
                'rootOptions' => ['label' => '<i class="fas fa-tree text-success"></i>'],
                'fontAwesome' => false,
                'asDropdown' => false,
                'multiple' => false,
                'options' => ['disabled' => false,],
                'treeOptions' => ['style' => 'height:150px']
            ]);
            ?>

        </div>
    </div>
    <div class="row objectively">
        <div class="col-lg-4">
            <?= $form->field($model, 'objectively')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?=
                    Select2::widget([
                        'name' => 'objectively_choose',
                        'data' => Objectively::getList(Objectively::TYPE_OBJECTIVELY),
                        'options' => [
                            'placeholder' => 'Выберите шаблон....',
                            'multiple' => false,
                            'id'=>'objectively_choose',
                        ],

                    ]);
                    ?>
                </div>
                <div class="panel-body">
                    <?= Objectively::renderEmptyForm(Objectively::TYPE_OBJECTIVELY) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row therapy">
        <div class="col-lg-4">
            <?= $form->field($model, 'therapy')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-lg-8">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <?=
                    Select2::widget([
                        'name' => 'therapy_choose',
                        'data' => Objectively::getList(Objectively::TYPE_THERAPY),
                        'options' => [
                            'placeholder' => 'Выберите шаблон....',
                            'multiple' => false,
                            'id'=>'therapy_choose',
                        ],

                    ]);
                    ?>
                </div>
                <div class="panel-body">
                    <?= Objectively::renderEmptyForm(Objectively::TYPE_THERAPY) ?>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'recommendations')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-lg-8">

            <?php echo TreeViewInput::widget([
                'id' => 'RecommendationsInput',
                'name' => 'RecommendationsInput',
                'value' => 'true', // preselected values
                'query' => Recommendations::find()->addOrderBy('root, lft'),
                'headingOptions' => ['label' => 'Рекоммендации'],
                'rootOptions' => ['label' => '<i class="fas fa-tree text-success"></i>'],
                'fontAwesome' => false,
                'asDropdown' => false,
                'multiple' => false,
                'options' => ['disabled' => false,],
                'treeOptions' => ['style' => 'height:150px']
            ]);
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'prescriptions')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-lg-8">

            <?php echo TreeViewInput::widget([
                'id' => 'PrescriptionsInput',
                'name' => 'PrescriptionsInput',
                'value' => 'true', // preselected values
                'query' => Prescriptions::find()->addOrderBy('root, lft'),
                'headingOptions' => ['label' => 'Назначения'],
                'rootOptions' => ['label' => '<i class="fas fa-tree text-success"></i>'],
                'fontAwesome' => false,
                'asDropdown' => false,
                'multiple' => false,
                'options' => ['disabled' => false,],
                'treeOptions' => ['style' => 'height:150px']
            ]);
            ?>

        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Сохранить' : 'Обновить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
