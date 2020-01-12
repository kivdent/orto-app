<?php
/*
 * Отображает меню для модуля
 */
use common\modules\patient\widgets\PatientMenuWidget;

use yii\helpers\Html;
use yii\web\View;
use common\modules\patient\models\Patient;


/* @var $this yii\web\View */
?>
<?php if (isset(Yii::$app->userInterface->params['patient_id'])): ?>
        <?php $patient=Patient::findOne(Yii::$app->userInterface->params['patient_id']);?>
    <h3><?= Html::encode("Карта N".$patient->getId()) ?>
    <?= Html::encode($patient->getFullName()) ?>
</h3>
<?= PatientMenuWidget::widget(['patient_id' => Yii::$app->userInterface->params['patient_id']]); ?>
<?php endif; ?>


