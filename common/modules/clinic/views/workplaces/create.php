<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\modules\clinic\models\Workplaces */

$this->title = 'Создание рабочего места';

?>
<div class="workplaces-create">

    <h1><?= Html::encode($this->title) ?></h1>
  
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
