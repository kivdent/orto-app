<?php

use common\modules\employee\models\Employee;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\TimeSheet */

$this->title = 'Изменение табеля сотрудника '. Employee::getEmployeeFullName($model->sotr).' за '.
    date('d.m.Y',strtotime($model->date));

?>
<div class="time-sheet-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
