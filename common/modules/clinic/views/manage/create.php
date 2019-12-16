<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $clinic common\modules\clinic\models\Clinic */

$this->title = 'Создание';
$this->params['breadcrumbs'][] = ['label' => 'Клиника', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="clinics-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php
//die("Create");
?>