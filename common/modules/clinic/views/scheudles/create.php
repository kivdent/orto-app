<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\clinic\models\ClinicSheudles */

$this->title = 'Создание расписания';

?>

<div class="clinic-sheudles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
