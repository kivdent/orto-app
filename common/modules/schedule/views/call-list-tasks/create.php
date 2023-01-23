<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\CallListTasks */

$this->title = 'Создание задачи';

?>
<div class="call-list-tasks-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
