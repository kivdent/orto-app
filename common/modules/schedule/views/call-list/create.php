<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\schedule\models\CallList */

$this->title = 'Новый список обзвона';
$this->params['breadcrumbs'][] = ['label' => 'Списки обзвона', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="call-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
