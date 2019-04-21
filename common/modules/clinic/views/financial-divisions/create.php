<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\clinic\models\FinancialDivisions */

$this->title = 'Создание финасового подразделения';

?>
<div class="financial-divisions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
