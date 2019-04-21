<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\employee\models\Employee */

$this->title = 'Изменить данные: ' . $model->fullName;

?>
<div class="employee-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
