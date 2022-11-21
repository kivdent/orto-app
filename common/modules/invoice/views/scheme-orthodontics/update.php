<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\invoice\models\SchemeOrthodontics */

$this->title = 'Изменение схемы оплат за ортодонтию';

?>
<div class="scheme-orthodontics-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
