<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model common\modules\clinic\models\Workplaces */

$this->title = $model->nazv;

\yii\web\YiiAsset::register($this);
?>
<div class="workplaces-view">

    <h1><?= Html::encode($this->title) ?>

  
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить '.$model->nazv.'?',
                'method' => 'post',
            ],
        ]) ?>
    </h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'nazv',

        ],
    ]) ?>

</div>
