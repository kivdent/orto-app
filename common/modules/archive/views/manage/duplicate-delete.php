<?php
/* @var $this yii\web\View */
/* @var $remainablePatient \common\modules\patient\models\Patient*/
/* @var $removablePatient \common\modules\patient\models\Patient*/

use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;

$this->title="Удаление дубликтов карт";
?>
<h1><?=$this->title?></h1>
<?= Html::a('Объеденить карты', ['unite','patient_id'=>$remainablePatient->id], [
    'class' => 'btn btn-success',
    'data' => [
        'confirm' => 'Вы уверены что хотите объеденить карты?',
        'method' => 'post',
    ],
]) ?>
<table class="table table-bordered">
    <tr>
        <th></th>
        <th>Оставить</th>
        <th>Удалить</th>
    </tr>
    <tr>
        <td class="active">Номер</td>
        <td class="success">
            <?=Html::a($remainablePatient->id,
                ['/patient/manage/update', 'patient_id' => $remainablePatient->id],
                ['target' => '_blank'])?>
        </td>
        <td class="danger">
            <?=Html::a($removablePatient->id,
                ['/patient/manage/update', 'patient_id' => $removablePatient->id],
                ['target' => '_blank'])?>
        </td>
    </tr>
    <tr>
        <td class="active">Фимилия</td>
        <td class="success"><?=$remainablePatient->surname?></td>
        <td class="danger"><?=$removablePatient->surname?></td>
    </tr>
    <tr>
        <td class="active">Имя</td>
        <td class="success"><?=$remainablePatient->name?></td>
        <td class="danger"><?=$removablePatient->name?></td>
    </tr>
    <tr>
        <td class="active">Отчество</td>
        <td class="success"><?=$remainablePatient->otch?></td>
        <td class="danger"><?=$removablePatient->otch?></td>
    </tr>
    <tr>
        <td class="active">Дата рождения</td>
        <td class="success"><?= UserInterface::getFormatedDate($remainablePatient->dr)?></td>
        <td class="danger"><?=UserInterface::getFormatedDate($removablePatient->dr)?></td>
    </tr>
    <tr>
        <td class="active">Мобильный телефон</td>
        <td class="success"><?=$remainablePatient->MTel?></td>
        <td class="danger"><?=$removablePatient->MTel?></td>
    </tr>
</table>
