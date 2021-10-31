<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\AppointmentsDay */

?>
<div class="appointments-day-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="form-group">
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы действительно хотите удалить расписание?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'disabled'=>'',
    ]) ?>

</div>
