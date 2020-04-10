<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\pricelists\models\PricelistItems */

$this->title = 'Изменить категорию';

?>
<div class="pricelist-items-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
