<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\images\models\Images */

$this->title = 'Изменить фотографию';

?>
<div class="images-update">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
