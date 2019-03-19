<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\old_app\models\Usersprava */

$this->title = 'Create Usersprava';
$this->params['breadcrumbs'][] = ['label' => 'Userspravas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usersprava-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
