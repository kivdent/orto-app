<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\user\models\CreateUserForm */

$this->title = 'Новый пользователь';
$this->params['breadcrumbs'][] = ['label' => 'Плдьзователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_create', [
        'model' => $model,
        'roles' => $roles,
    ]) ?>

</div>
