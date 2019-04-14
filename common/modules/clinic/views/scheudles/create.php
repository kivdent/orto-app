<?php

use yii\helpers\Html;
use common\modules\clinic\widgets\ClinicManageMenuWidget;
/* @var $this yii\web\View */
/* @var $model common\modules\clinic\models\ClinicSheudles */

$this->title = 'Создание расписания';

?>
<?= ClinicManageMenuWidget::widget(['clinic_id'=> $model->clinic_id]);?>
<div class="clinic-sheudles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
