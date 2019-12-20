<?php

use common\modules\employee\models\Employee;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\patient\models\TreatmentPlan */

/* @var $modelsPlanItem common\modules\patient\models\PlanItemForm*/

$this->title = 'Изменение плана лечения от ' . Yii::$app->formatter->asDate($model->created_at,'php:d.m.Y');

?>
<div class="treatment-plan-update">

    <h3><?= Html::encode($this->title) ?></h3>
    <h3>Врач: <?=Employee::findOne($model->author)->getFullName()?></h3>
    <?= $this->render('_form', [
        'model' => $model,
        'modelsPlanItem' => $modelsPlanItem
    ]) ?>

</div>
