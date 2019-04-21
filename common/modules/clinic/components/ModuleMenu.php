<?php

use common\modules\clinic\widgets\ClinicManageMenuWidget;

/* @var $this yii\web\View */
?>
<?php if (isset(Yii::$app->userInterface->params['clinic_id'])): ?>
    <?= ClinicManageMenuWidget::widget(['clinic_id' => Yii::$app->userInterface->params['clinic_id']]); ?>
<?php else: ?>
<?php Yii::$app->controller->redirect(['/clinic/manage'])?>
<?php endif; ?>