<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\pricelists\models\Pricelist */

$this->title = 'Новый прейскурант';

?>
<div class="pricelist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
