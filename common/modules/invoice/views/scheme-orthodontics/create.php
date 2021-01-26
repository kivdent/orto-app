<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\invoice\models\SchemeOrthodontics */

$this->title = 'Create Scheme Orthodontics';
$this->params['breadcrumbs'][] = ['label' => 'Scheme Orthodontics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scheme-orthodontics-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
