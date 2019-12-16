<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\patient\models\TreatmentPlan */

/* @var $modelsPlanItem common\modules\patient\models\PlanItemForm*/

$this->title = 'Изменение плана лечения: ' . $model->id;

?>
<div class="treatment-plan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsPlanItem' => $modelsPlanItem
    ]) ?>

</div>
