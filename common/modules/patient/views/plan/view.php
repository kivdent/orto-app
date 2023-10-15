<?php

use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\patient\models\TreatmentPlan */

$this->title = "План лечения от " . Yii::$app->formatter->asDate($model->created_at, 'php:d.m.Y');
$i = 1;

?>

<div class="treatment-plan-view">

    <h1><?= Html::encode($this->title) ?>
        <?= Html::a('Печать плана', ['print', 'patient_id' => Yii::$app->userInterface->params['patient_id'], 'id' => $model->id, 'print' => 'true'], ['class' => 'btn btn-primary', 'target' => '_blank']) ?>
        <?= Html::a('Печать сметы', ['print-budget', 'patient_id' => Yii::$app->userInterface->params['patient_id'], 'id' => $model->id, 'print' => 'true'], ['class' => 'btn btn-primary', 'target' => '_blank']) ?>
        <?= Html::a('Список', ['index', 'patient_id' => Yii::$app->userInterface->params['patient_id']], ['class' => 'btn btn-primary',]) ?>
        <?php if ($model->author == UserInterface::getEmployeeId()): ?>
            <?= Html::a('Изменить', ['update', 'patient_id' => Yii::$app->userInterface->params['patient_id'], 'id' => $model->id,], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Удалить', ['delete', 'patient_id' => Yii::$app->userInterface->params['patient_id'], 'id' => $model->id,], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить план лечения',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </h1>

    <p><?= Html::encode($model->comments) ?></p>

    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-6">
                    <h4>Врач: <?= $model->getAuthorName() ?></h4>
                    <h4>Диагноз: <?= Html::encode($model->diagnosis['Nazv']) ?></h4>
                    <h4>Примерная стоимость: <?= $model->getPrice() ?></h4>
                </div>
                <div class="col-lg-6">
                    <h4 class="text-right"><?= $model->statusTitle ?></h4>

                </div>

            </div>

        </div>

        <!-- Table -->
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Область</th>
                <th scope="col">Рекомендация</th>
                <th scope="col">Стоимость</th>
                <th scope="col">Примерный срок</th>
                <th scope="col">Комментарий</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($model->planItems as $planlItem): ?>
                <tr>
                    <th scope="row"><?= Html::encode($i++) ?></th>
                    <td><?= Html::encode($planlItem->regionTitle) ?></td>
                    <td><?= Html::encode($planlItem->operationTitle) ?></td>
                    <td><?= $planlItem->price_actual===0? Html::encode($planlItem->price_from) .'-'. Html::encode($planlItem->price_to) : Html::encode($planlItem->price_actual) ?></td>
                    <td><?= Html::encode($planlItem->duration_from) ?>-<?= Html::encode($planlItem->duration_to) ?></td>
                    <td><?= Html::encode($planlItem->commentText) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
