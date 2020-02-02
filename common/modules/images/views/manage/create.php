<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\images\models\Images */

$this->title = 'Загрузка фотографии';

?>
<div class="images-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
