<?php

/* @var $items array */
/* @var $from \yii\widgets\ActiveForm*/
/* @var $model */

use common\modules\patient\models\Diagnosis;
use kartik\select2\Select2;

$form->field($model, 'diagnosis_id')->
widget(Select2::classname(), [
    'data' => $items,
    'options' => ['placeholder' => 'Выберете диагноз ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
