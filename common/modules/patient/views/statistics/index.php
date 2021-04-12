<?php
/* @var $this yii\web\View */
/* @var $statistics \common\modules\patient\models\Statistics*/

use common\modules\userInterface\models\UserInterface;

$this->title="Статистика пациента"
?>
<h3>
    <?=$this->title?>
</h3>
<table class="table table-bordered">
    <tr>
        <td>Дисконтная карта</td>
        <td><?=$statistics->discountCardNumber?></td>
        <td><?=$statistics->discountCardType?></td>
    </tr>
    <tr>
        <td>Профессиональная гигиена</td>
        <td><?=$statistics->professionalHygieneDate?></td>
        <td><?=$statistics->professionalHygieneEmployee?></td>
    </tr>
    <tr>
        <td>Флорида Проуб</td>
        <td><?=$statistics->FPDate?></td>
        <td><?=$statistics->FPEmployee?></td>
    </tr>
    <tr>
        <td>Вектор терапия</td>
        <td><?=$statistics->vectorDate?></td>
        <td><?=$statistics->vectorEmployee?></td>
    </tr>
    <tr>
        <td>Ортопедия</td>
        <td><?=$statistics->orthopedicsDate?></td>
        <td><?=$statistics->orthopedicsEmployee?></td>
    </tr>
    <tr>
        <td>Ортодонтия</td>
        <td><?=$statistics->orthodonticsDate?></td>
        <td><?=$statistics->orthodonticsEmployee?></td>
    </tr>

</table>

<?php if (UserInterface::getRoleName(Yii::$app->user->id)=== UserInterface::ROLE_SENIOR_NURSE):?>

<table class="table table-bordered">
    <tr>
        <td>Год</td>
        <td>Сумма</td>
        <td>Даты оплат</td>
    </tr>
    <?php foreach ($statistics->yearStatistics as $year=>$statistic):?>
        <tr>
            <td><?=$year?></td>
            <td><?=$statistic['total']?></td>
            <td><?=$statistic['paymentDates']?></td>
        </tr>
    <?php endforeach;?>
</table>
<?php endif;?>
