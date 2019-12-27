<?php

use yii\helpers\Html;

use common\assets\PrintAsset;


/* @var $this yii\web\View */
/* @var $model common\modules\patient\models\TreatmentPlan */

$this->title = "План лечения";
$i = 1;
//\yii\web\YiiAsset::register($this);
PrintAsset::register($this);
?>


<div class="raw">
    <div class="col-xs-5">
        <?=
        Html::img('/images/logo orto premier.png', ['width' => 200])
        ?>
    </div>
    <div class="col-xs-7 small">
        Новокузнецк, пр. Кузнецкстроевский д.30 п.73<br>+7 (3843) 45 46 33, +7-913-429-97-23
    </div>
</div>
<div class="raw text-center">
    <div class="col-xs-12">
        <b><?= Html::encode($this->title) ?></b>
    </div>

</div>

<div class="small">
    <div class="col-xs-6">
        Дата : <?= Yii::$app->formatter->asDate($model->created_at, 'php:d.m.Y') ?><br>
        Пациент: <?= $model->getPatientName() ?>

    </div>
    <div class="col-xs-6">
        Врач: <?= $model->getAuthorName() ?><br>
        Диагноз: <?= Html::encode($model->diagnosis['Nazv']) ?>
    </div>
</div>


<p><?= Html::encode($model->comments) ?></p>


<!-- Table -->
<table class="table small">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Область</th>
        <th scope="col">Рекомендация</th>
        <th scope="col">Примерная стоимость</th>
        <th scope="col">Комментарий</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Примерная стоимость:</td>
        <td><?= Html::encode($model->getPrice()) ?></td>
        <td>&nbsp;</td>
    </tr>
    </tfoot>
    <tbody>
    <?php foreach ($model->planItems as $planlItem): ?>
        <tr>
            <th scope="row"><?= Html::encode($i++) ?></th>
            <td><?= Html::encode($planlItem->region->title) ?></td>
            <td><?= Html::encode($planlItem->operation->title) ?></td>
            <td><?= Html::encode($planlItem->price_from) ?>-<?= Html::encode($planlItem->price_to) ?></td>
            <td><?= Html::encode($planlItem->comment) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<div class="raw small">
    <div class="col-xs-6">
        <p>Пациент:_______________________<br><?= $model->getPatientName() ?> </p>
    </div>
    <div class="col-xs-6">
        <p>Врач:____________________________<br><?= $model->getAuthorName() ?></p>
    </div>
</div>

<script>
    window.print();
</script>