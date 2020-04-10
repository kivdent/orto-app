<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelPricelistItems common\modules\pricelists\models\PricelistItems */
/* @var  $modelPrices \common\modules\pricelists\models\Prices*/

$this->title = 'Изменить категорию';

?>
<div class="pricelist-items-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_price', [
        'modelPricelistItems' => $modelPricelistItems,
        'modelPrices'=>$modelPrices
    ]) ?>

</div>
