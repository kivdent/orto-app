<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\pricelists\models\Pricelist */

$this->title = 'Изменения прейскуранта: ' . $model->title;

?>
<div class="pricelist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
