<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\pricelists\models\PricelistItems */

$this->title = 'Новая категория';

?>
<div class="pricelist-items-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
