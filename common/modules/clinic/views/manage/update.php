<?php

use yii\helpers\Html;
use common\modules\clinic\widgets\ClinicManageMenuWidget;
/* @var $this yii\web\View */
/* @var $model common\models\Clinics */

$this->title =$model->name;

?>
<?= ClinicManageMenuWidget::widget(['clinic_id'=> $model->clinic->id]);?>
 
<div class="clinics-update">

    <h1><?= Html::encode($this->title) ?> <?= Html::a('Удалить', ['delete', 'id' => $model->clinic->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить клинику?',
                'method' => 'post',
            ],
        ]) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
