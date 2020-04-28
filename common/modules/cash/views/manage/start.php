<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

/* @var $sum integer */

?>
<?= Html::beginForm('start'); ?>
<h1>Начало кассовой смены</h1>

<div class="well">
    <h2>Остаток в кассе <?= $sum ?> р.</h2>
</div>
    <input type="hidden" name="validate" value="1">
    <button type="submit" value="Открыть" class="btn btn-success">Открыть</button>
    <?= Html::endForm() ?>

