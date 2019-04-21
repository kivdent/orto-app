<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\modules\clinic\models\ClinicSheudles */

$this->title = $model->name;

?>
<div class="clinic-sheudles-update">

    <h1><?= Html::encode($this->title) ?>
        
         
        
    </h1>
    <p>
        <?php if($model->status):?>
        <?= Html::a('Инактивировать', ['inactivate', 'id' => $model->id,'clinic_id' => $model->clinic_id], ['class' => 'btn btn-primary']) ?>
        <?php ELSE: ?>
        <?= Html::a('Активировать', ['inactivate', 'id' => $model->id,'clinic_id' => $model->clinic_id], ['class' => 'btn btn-primary']) ?>
            <?php endif;?>
        <?=
        Html::a('Удалить', ['delete', 'id' => $model->id,'clinic_id' => $model->clinic_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить' . $model->name . '?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
