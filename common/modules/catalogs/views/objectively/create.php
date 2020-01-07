<?php

use common\modules\catalogs\models\ObjectivelyItems;
use common\modules\catalogs\models\ObjectivelySubItems;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelObjectively common\modules\catalogs\models\Objectively */

$this->title = 'Создать с';
$this->params['breadcrumbs'][] = ['label' => 'Объективно', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="objectively-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [

        'modelObjectively' => $modelObjectively,
        'modelsObjectivelyItems' => (empty($modelsObjectivelyItems)) ? [new ObjectivelyItems] : $modelsObjectivelyItems,
        'modelsObjectivelySubItems' => (empty($modelsObjectivelySubItems)) ? [[new ObjectivelySubItems]] : $modelsObjectivelySubItems,

    ]) ?>

</div>
