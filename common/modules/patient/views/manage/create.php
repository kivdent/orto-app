<?php

use yii\helpers\Html;
$this->context->layout = '@frontend/views/layouts/light.php';
/* @var $this yii\web\View */
/* @var $model common\modules\patient\models\Patient */

$this->title = 'Новый пациент';

?>
<div class="patient-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
