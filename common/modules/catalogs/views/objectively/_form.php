<?php
use kidzen\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\catalogs\models\Objectively;
use common\modules\catalogs\models\ObjectivelyItems;
use common\modules\catalogs\assets\ObjectivelyAsset;
use  yii\web\View;

/* @var $this yii\web\View */
/* @var $modelObjectively common\modules\catalogs\models\Objectively */
/* @var $form yii\widgets\ActiveForm */
/*  person ->   Objectively
    House->     ObjectivelyItems
    Room->      ObjectivelySubItems

*/
ObjectivelyAsset::register($this);
$this->registerJs(
    Objectively::getOptionsScript(),
    View::POS_HEAD,
    'templateOptions'
);

?>



<div class="objectevly-form">

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<div class="row">
    <div class="col-sm-6">
        <?= $form->field($modelObjectively, 'name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($modelObjectively, 'type')->dropDownList(Objectively::getTypeList()) ?>
    </div>
</div>

<div class="padding-v-md">
    <div class="line line-dashed"></div>
</div>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper',
    'widgetBody' => '.container-items',
    'widgetItem' => '.house-item',
    'limit' => 100,
    'min' => 1,
    'insertButton' => '.add-house',
    'deleteButton' => '.remove-house',
    'model' => $modelsObjectivelyItems[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'value',
        'type',
    ],
]); ?>
<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>Компонент</th>
        <th style="width: 450px;">Содержание</th>

    </tr>
    </thead>
    <tbody class="container-items">
    <?php foreach ($modelsObjectivelyItems as $indexObjectivelyItems => $modelObjectivelyItems): ?>
        <tr class="house-item">
            <td class="vcenter">
                <?php
                // necessary for update action.
                if (! $modelObjectivelyItems->isNewRecord) {
                    echo Html::activeHiddenInput($modelObjectivelyItems, "[{$indexObjectivelyItems}]id");
                }
                ?>
               <?= $form->field($modelObjectivelyItems, "[{$indexObjectivelyItems}]type")
                   ->dropDownList(ObjectivelyItems::getTypeList(),[
                           'index'=>$indexObjectivelyItems,
                       'class'=>'form-control type-select',

                   ])?>
                <button type="button" class="remove-house btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button><button type="button" class="add-house btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>

            </td>
            <td>
                <?= $this->render('_form-sub-items',[
                    'form' => $form,
                    'indexObjectivelyItems' => $indexObjectivelyItems,
                    'modelsObjectivelySubItems' => $modelsObjectivelySubItems[$indexObjectivelyItems],
                    'type'=>$modelObjectivelyItems->type,
                ]) ?>
            </td>

        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php DynamicFormWidget::end(); ?>

<div class="form-group">
    <?= Html::submitButton($modelObjectively->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>