<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\reports\models\FinancialPeriods */

$this->title = 'Финансовый период:'.$model->id;

\yii\web\YiiAsset::register($this);
?>
<div class="financial-periods-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nach',
            'okonch',
            'uet',
            'weekends',
        ],
    ]) ?>

</div>
