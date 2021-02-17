<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\reports\models\FinancialPeriods */

$this->title = 'Новый финансовый период';

?>
<div class="financial-periods-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
