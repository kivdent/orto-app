<?php

use yii\helpers\Html;
use common\modules\clinic\widgets\ClinicManageMenuWidget;
/* @var $this yii\web\View */
/* @var $model common\modules\clinic\models\Workplaces */

$this->title = 'Создание рабочего места';

?>
  <?= ClinicManageMenuWidget::widget(['clinic_id'=> $model->clinic_id]);?>
<div class="workplaces-create">

    <h1><?= Html::encode($this->title) ?></h1>
  
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
