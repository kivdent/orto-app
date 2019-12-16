<?php

use common\modules\clinic\widgets\PatientMenuWidget;
use common\modules\clinic\models\Clinic;

/* @var $this yii\web\View */
?>
<?php if (isset(Yii::$app->userInterface->params['clinic_id'])): ?>
    <?= PatientMenuWidget::widget(['clinic_id' => Yii::$app->userInterface->params['clinic_id']]); ?>
<?php elseif (Clinic::hasClinics()): ?>
<?php Yii::$app->controller->redirect(['/clinic/manage'])?>
<?php endif; ?>