<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\employee\models\Employee */

$this->title = $model->fullName;

\yii\web\YiiAsset::register($this);
?>
<div class="employee-view">

    <h3><?= Html::encode($this->title) ?></h3>
<h4><?= Html::encode($model->positionName) ?></h4>
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
        <?=
        Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'dr:date',
            'dtel',
            'mtel',
            [
                'attribute'=>'adres',
                'format'=>'raw',
                'value'=>function($model){
                return $model->addressString;
                }
            ],
        ],
    ])
    ?>

</div>
