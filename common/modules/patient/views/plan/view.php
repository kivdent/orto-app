<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\modules\employee\models\Employee;


/* @var $this yii\web\View */
/* @var $model common\modules\patient\models\TreatmentPlan */

$this->title = "План лечения от ".Yii::$app->formatter->asDate($model->created_at,'php:d.m.Y');
$i=0;
\yii\web\YiiAsset::register($this);
?>
<div class="treatment-plan-view">

    <h1><?= Html::encode($this->title) ?>
        <?= Html::a('Изменить', ['update', 'patient_id' =>Yii::$app->request->get('patient_id'),'id'=>$model->id,], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'patient_id' => Yii::$app->request->get('patient_id'),'id'=>$model->id,], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить план лечения',
                'method' => 'post',
            ],
        ]) ?></h1>


    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">Врач: <?=Employee::findOne($model->author)->getFullName()?></div>

        <!-- Table -->
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Область</th>
                <th scope="col">Рекомендация</th>
                <th scope="col">Комментарий</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($model->planItems as $planlItem): ?>
            <tr>
                <th scope="row"><?=Html::encode($i++)?></th>
                <td><?=Html::encode($planlItem->region_id)?></td>
                <td><?=Html::encode($planlItem->operation_id)?></td>
                <td><?=Html::encode($planlItem->comment)?></td>
            </tr>
             <?php endforeach;?>
            </tbody>
        </table>
    </div>

</div>
