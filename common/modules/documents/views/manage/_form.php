<?php

use kartik\tree\TreeViewInput;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use common\modules\documents\models\Notes;
use common\modules\documents\assets\DocumentsAsset;

/* @var $this yii\web\View */
/* @var $model common\models\Notes */
/* @var $form yii\widgets\ActiveForm */
/* @var $type string */

DocumentsAsset::register($this);

?>

<div class="notes-form">

    <?php $form = ActiveForm::begin(); ?>


    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
        </div>
        <?php if ($type !== 'text'): ?>

        <?php
        $this->registerJs(
            Notes::getJsArray($type),
            View::POS_HEAD
        );
        ?>
        <div class="col-lg-8">
            <?php echo TreeViewInput::widget([
                'id' => 'TextInput',
                'name' => 'TextInput',
                'value' => 'false', // preselected values
                'query' => Notes::getClassesList()[$type]::find()->addOrderBy('root, lft'),
                'headingOptions' => ['label' => Notes::getTypesList()[$type]],
                'rootOptions' => ['label' => '<i class="fas fa-tree text-success"></i>'],
                'fontAwesome' => false,
                'asDropdown' => false,
                'multiple' => false,
                'options' => ['disabled' => false,],
                'treeOptions' => ['style' => 'height:150px']
            ]);
            ?>
            <?php endif; ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
