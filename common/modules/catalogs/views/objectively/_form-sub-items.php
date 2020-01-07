<?php


use kidzen\dynamicform\DynamicFormWidget;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $modelObjectively common\modules\catalogs\models\Objectively */
/* @var $form yii\widgets\ActiveForm */
/*  person ->   Objectively
    House->     ObjectivelyItems
    Room->      ObjectivelySubItems

*/
?>
<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner',
    'widgetBody' => '.container-rooms',
    'widgetItem' => '.room-item',
    'limit' => 4,
    'min' => 1,
    'insertButton' => '.add-room',
    'deleteButton' => '.remove-room',
    'model' => $modelsObjectivelySubItems[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'value'
    ],
]); ?>
    <table class="table table-bordered">

        <tbody class="container-rooms">
        <?php foreach ($modelsObjectivelySubItems as $indexObjectivelySubItems => $modelObjectivelySubItems): ?>
            <tr class="room-item">
                <td class="vcenter">
                    <?php
                    // necessary for update action.
                    if (! $modelObjectivelySubItems->isNewRecord) {
                        echo Html::activeHiddenInput($modelObjectivelySubItems, "[{$indexObjectivelyItems}][{$indexObjectivelySubItems}]id");
                    }
                    ?>
                    <?= $form->field($modelObjectivelySubItems, "[{$indexObjectivelyItems}][{$indexObjectivelySubItems}]value")->label(false)->textInput(['maxlength' => true]) ?>
                </td>
                <td class="text-center vcenter" style="width: 90px;">
                    <button type="button" class="remove-room btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button><button type="button" class="add-room btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php DynamicFormWidget::end(); ?>