<?php

use yii\helpers\Html;
use common\modules\clinic\widgets\ClinicManageMenuWidget;
/* @var $this yii\web\View */
/* @var $model common\modules\clinic\models\Workplaces */

$this->title = 'Update Workplaces: ' . $model->nazv;

?>
  <?= ClinicManageMenuWidget::widget(['clinic_id'=> $model->clinic_id]);?>
<div class="workplaces-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
