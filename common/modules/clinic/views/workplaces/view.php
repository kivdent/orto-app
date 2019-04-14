<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\modules\clinic\widgets\ClinicManageMenuWidget;
/* @var $this yii\web\View */
/* @var $model common\modules\clinic\models\Workplaces */

$this->title = $model->nazv;

\yii\web\YiiAsset::register($this);
?>
  <?= ClinicManageMenuWidget::widget(['clinic_id'=> $model->clinic_id]);?>
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
