<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
$this->context->layout = '@frontend/views/layouts/light.php';
/* @var $this yii\web\View */
/* @var $model common\modules\patient\models\Patient */

$this->title = $model->fullName;

\yii\web\YiiAsset::register($this);
?>
<div class="patient-view">

    <h1>Карта № <?= Html::encode($model->getId()) ?></h1>
    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::a('Изменить', ['update', 'patient_id' => $model->id], ['class' => 'btn btn-primary']) ?>
          <?= Html::a('Карта', ['/old_app/pat_card.php', 'id' => $model->id], ['class' => 'btn btn-info','target'=>'blank']) ?>

    </p>
  
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'dr:date',
            'sex',
            
            
            [
                'attribute' => 'adres',
                'format' => 'raw',
                 'value' => function ($model) {
                   
                    return $model->addressString;
                },
            ],
            'MTel',
            'DTel',
            'RTel', 
            'email:email',
            'MestRab',
            'prof',
          
            'Prim:ntext',
        ],
    ])
    ?>

</div>
