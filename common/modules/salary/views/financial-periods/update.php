<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\reports\models\FinancialPeriods */

$this->title = 'Изменить финансовый период: ' . $model->id;

?>
<div class="financial-periods-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
