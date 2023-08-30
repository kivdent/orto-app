<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\patient\models\TreatmentPlanForm */
/* @var $modelsPlanItem common\modules\patient\models\PlanItemForm */

$this->title = 'Новый план лечения';
\common\modules\patient\assets\TreatmentPlanVueAsset::register($this);

?>
<div class="treatment-plan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div id="treatmentPlan"
         >
    </div>


</div>
