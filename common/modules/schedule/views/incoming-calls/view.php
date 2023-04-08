<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\IncomingCalls */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Incoming Calls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="incoming-calls-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'doctor_id',
            'created_at',
            'updated_at',
            'employee_id',
            'primary_patient',
            'call_target:ntext',
            'call_result',
            'by_recommendation',
            'rejection_reasons_id',
        ],
    ]) ?>

</div>
