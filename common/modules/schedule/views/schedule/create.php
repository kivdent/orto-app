<?php

use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\AppointmentsDay */
/* @var $disabled string*/

$this->title = 'Создание расписания '.date('d.m.Y',strtotime($model->date)).' '. UserInterface::getDayWeekName(date('N',strtotime($model->date)));

?>
<div class="appointments-day-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'disabled'=>$disabled
    ]) ?>

</div>
