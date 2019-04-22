<?php
/** @var $this yii\web\View */

use yii\helpers\Url;


$this->title = 'Каталоги'

?>
<h1><?= $this->title ?></h1>
<table class="table">
    <tbody>
    <tr>
        <td>
            <a href="<?= Url::to(['/catalogs/baseSchedulesTypes']) ?>">Типы базового расписания</a><br>
        </td>
    </tr>
    <tr>
        <td>
            <a href="<?= Url::to(['/catalogs/positions']) ?>">Должности</a>
        </td>
    </tr>
    </tbody>
</table>

