<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\modules\clinic\models\Workplaces */

$this->title = 'Update Workplaces: ' . $model->nazv;

?>
<div class="workplaces-update">
<?=
        Html::a('Удалить', ['delete', 'id' => $model->id,'clinic_id' => $model->clinic_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить' . $model->name . '?',
                'method' => 'post',
            ],
        ])
        ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
