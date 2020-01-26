<?php

use yii\helpers\Html;
use common\modules\documents\models\Notes;
/* @var $this yii\web\View */
/* @var $model common\models\Notes */
/* @var $type string*/

$this->title = Notes::getTypesList()[$type];

?>
<div class="notes-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
        'type' => $type,
    ]) ?>

</div>
