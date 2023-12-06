<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\invoice\models\SchemeOrthodontics */
/* @var $form string*/


$this->title = 'Создать схему расчётов за ортодонтию';
?>
<div class="scheme-orthodontics-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render($form, [
        'model' => $model,
    ]) ?>

</div>
