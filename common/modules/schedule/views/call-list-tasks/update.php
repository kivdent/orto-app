<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\CallListTasks */

$this->title = 'Изменить задачу';
?>
<div class="call-list-tasks-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
